<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;

use App\Model\CommitmentModel;
use App\Model\EmployeeModel;
use App\Model\Entity\Commitment;
use App\Model\Entity\MonthSet;
use App\Model\Entity\MonthSetHolliday;
use App\Model\MainSubjectModel;
use App\Model\MonthSetHollidayModel;
use App\Model\MonthSetModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\DateTime;

class MonthSetHollidayFormControl extends Control
{
	/**
	 * @var MonthSetHollidayModel
	 */
	protected $MonthSetHollidayModel;

	/**
	 * @var MonthSetModel
	 */
	protected $MonthSetModel;

	/**
	 * @var EmployeeModel
	 */
	protected $EmployeeModel;

	/**
	 * @var MainSubjectModel
	 */
	protected $MainSubjectModel;

	/**
	 * @var CommitmentModel
	 */
	protected $CommitmentModel;

	/**
	 * @var MonthSet
	 */
	protected $month_set_entity;

	/**
	 * @var MonthSetHolliday
	 */
	protected $month_set_holliday_entity;

	/**
	 * @var integer
	 */
	protected $id = false;

	/**
	 * @var integer
	 */
	protected $month_set_id = false;

	/**
	 * @var integer
	 */
	protected $employee_id = false;

	/**
	 * @var integer
	 */
	protected $commitment_id = false;

	/**
	 * MonthSetHollidayFormControl constructor.
	 * @param MonthSetHollidayModel $monthSetHollidayModel
	 */
	public function __construct( CommitmentModel $commitmentModel, MonthSetModel $monthSetModel, MonthSetHollidayModel $monthSetHollidayModel,MainSubjectModel $mainSubjectModel, EmployeeModel $employeeModel )
	{
		$this->MonthSetModel = $monthSetModel;
		$this->MonthSetHollidayModel = $monthSetHollidayModel;
		$this->EmployeeModel = $employeeModel;
		$this->MainSubjectModel = $mainSubjectModel;
		$this->CommitmentModel = $commitmentModel;
	}

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
		$this->month_set_entity = $this->month_set_holliday_entity->getMonth_set();
	}

	/**
	 * @param $id
	 */
	public function setMonthSetId( $id )
	{
		$this->month_set_id = (int)$id;
		$this->month_set_entity = $this->MonthSetModel->find($this->month_set_id);

	}

	/**
	 * @param $id
	 */
	protected function setEmployee( $id )
	{
		$this->employee_id = (int)$id;
	}

	protected function setCommitment( $id )
	{
		$this->commitment_id = (int)$id;
		$this['form']['commitment_id']->setDefaultValue($this->commitment_id);
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form
			->addSelect('employee', 'Zaměstnanec', $this->EmployeeModel->getListByMainSubject($this->month_set_entity->getMain_subject()->getId(), true))->setPrompt('Vyber zaměstnance')->setHtmlAttribute('class', 'month-set-holliday-form-employee-select');

		$form
			->addSelect('commitment', 'Činnost:')
			->setPrompt('Vyber činnost')
			->setHtmlAttribute('class', 'commitment-select chosen-select');

		if($this->employee_id)
			$form['employee']->setDefaultValue($this->employee_id);

		$form
			->addText('start', 'Dovolená od:')
			->addRule(Form::FILLED, 'Musíte zadat začátek dovolené')
			->setHtmlAttribute('class', 'date-from')
			->setHtmlAttribute('autocomplete', 'off')
			->setHtmlAttribute('placeholder', 'Dovolená od');

		$form
			->addCheckbox('half_day_start', 'Půlden')
			->setHtmlAttribute('class', 'half-day-start');

		$form->addHidden('commitment_id')->setHtmlAttribute('id', 'commitment-id');

		$form
			->addText('stop', 'Dovolená do:')
			->addRule(Form::FILLED, 'Musíte zadat konec dovolené')
			->setHtmlAttribute('class', 'date-to')
			->setHtmlAttribute('autocomplete', 'off')
			->setHtmlAttribute('placeholder', 'Dovolená do');

		$form
			->addCheckbox('half_day_stop', 'Půlden')
			->setHtmlAttribute('class', 'half-day-stop');


		$form
			->addRadioList('type', 'Typ dovolené:', array('1' => 'Řádná dovolená', '2' => 'Neplacené volno'))->setHtmlAttribute('class', '')->setDefaultValue(1);

		$form
			->addTextArea('note', 'Poznámka')
			->setHtmlAttribute('placeholder', 'Poznámka');

		$form
			->addSubmit('submit', 'Ulož')
			->setHtmlAttribute('class', 'submit');

		$form->onSuccess[] = array($this, 'formSubmit');

		if( $this->id )
			$form->setDefaults($this->MonthSetModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		$start_date = new \DateTime( $data->start );
		$stop_date = new \DateTime( $data->stop );

		if( $start_date > $stop_date ) {
			$this->presenter->flashMessage('Špatné zadání data');
		} else {
			if( $data->commitment_id == 'x' ) {
				$employee_commitments = $this->CommitmentModel->getCommitmentsByEmployee((int)($data->employee));

				foreach ( $employee_commitments as $commitment ) {
					$this->createNewHolliday($this->month_set_id, $data->type, $data->employee, $commitment->getId(), $start_date, $stop_date, $data->half_day_start, $data->half_day_stop, $data->note);

				}
			}
			else{
				$this->createNewHolliday($this->month_set_id, $data->type, $data->employee, $data->commitment_id, $start_date, $stop_date, $data->half_day_start, $data->half_day_stop, $data->note);
			}

			$this->presenter->flashMessage('Uloženo');
			$this->presenter->redirect('this');

		}

	}


	protected function createNewHolliday($month_set_id, $type, $employee_id, $commitment_id, $start_date, $stop_date, $half_day_start, $half_day_stop, $note = null )
	{
		$entity = new MonthSetHolliday();

		$entity->setType( $type);
		$entity->setStart( $start_date);
		$entity->setStop( $stop_date);
		$entity->setNote( $note );
		$entity->setEmployee( $this->EmployeeModel->find((int)$employee_id));

		$entity->setHalf_day_start( $half_day_start );
		$entity->setHalf_day_stop( $half_day_stop );

		$commitment_entity = $this->CommitmentModel->find((int)$commitment_id);
		$entity->setCommitment( $commitment_entity );

		$month_set_entity = $this->MonthSetModel->find((int)$month_set_id);
		$entity->setMonthSet( $month_set_entity );

		$this->MonthSetHollidayModel->save($entity);

		return true;
	}

	public function handleSetEmployee( $id )
	{
		$this->setEmployee((int)$id);
		if( $this->employee_id ) {
			$employee_commitments = $this->CommitmentModel->getCommitmentsByEmployee((int)$this->employee_id, true);
			if(count($employee_commitments) > 1)
				$employee_commitments['x'] = 'pro všechny úvazky';
		}
		else {
			$employee_commitments = array();
		}

		$this['form']['commitment']->setItems($employee_commitments);

		$this->redrawControl('holliday-form');

	}

	public function handleSetCommitment( $id )
	{
		$this->setCommitment((int)$id);
	}

	public function render()
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}