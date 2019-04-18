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
use App\Model\Entity\MonthSetStudyHolliday;
use App\Model\MainSubjectModel;
use App\Model\MonthSetHollidayModel;
use App\Model\MonthSetModel;
use App\Model\MonthSetStudyHollidayModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\DateTime;

class MonthSetStudyHollidayFormControl extends Control
{
	/**
	 * @var MonthSetStudyHollidayModel
	 */
	protected $MonthSetStudyHollidayModel;

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
	 * @var MonthSetStudyHolliday
	 */
	protected $month_set_study_holliday_entity;

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
	 * MonthSetStudyHollidayFormControl constructor.
	 * @param CommitmentModel $commitmentModel
	 * @param MonthSetModel $monthSetModel
	 * @param MonthSetStudyHollidayModel $monthSetStudyHollidayModel
	 * @param MainSubjectModel $mainSubjectModel
	 * @param EmployeeModel $employeeModel
	 */
	public function __construct( CommitmentModel $commitmentModel, MonthSetModel $monthSetModel, MonthSetStudyHollidayModel $monthSetStudyHollidayModel, MainSubjectModel $mainSubjectModel, EmployeeModel $employeeModel )
	{
		$this->MonthSetModel = $monthSetModel;
		$this->MonthSetStudyHollidayModel = $monthSetStudyHollidayModel;
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

		if($this->employee_id)
			$form['employee']->setDefaultValue($this->employee_id);

		$form
			->addSelect('commitment', 'Úvazek:')
			->setPrompt('Vyber činnost')
			->setHtmlAttribute('class', 'commitment-select chosen-select');

		$form->addHidden('commitment_id')->setHtmlAttribute('id', 'commitment-id');

		$form
			->addText('date_from', 'Od')
			->addRule(Form::FILLED, 'Musíte zadat datum od kdy bylo studijní volno uděleno!')
			->setHtmlAttribute('class', 'date-from')
			->setHtmlAttribute('autocomplete', 'off')
			->setHtmlAttribute('placeholder', 'Od');

		$form
			->addCheckbox('from_halfday', 'Půlden')
			->setHtmlAttribute('class', 'date-from-halfdate');;

		$form
			->addText('date_to', 'Do')
			->addRule(Form::FILLED, 'Musíte zadat datum do kdy bylo studijní volno uděleno!')
			->setHtmlAttribute('class', 'date-to')
			->setHtmlAttribute('autocomplete', 'off')
			->setHtmlAttribute('placeholder', 'Do');


		$form
			->addCheckbox('to_halfday', 'Půlden')
			->setHtmlAttribute('class', 'date-to-halfdate');

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

		$start_date = new \DateTime( $data->date_from );
		$stop_date = new \DateTime( $data->date_to );

		if( $start_date > $stop_date ) {
			$this->presenter->flashMessage('Špatné zadání data');
		} else {
			if( $data->commitment_id == 'x' ) {
				$employee_commitments = $this->CommitmentModel->getCommitmentsByEmployee((int)($data->employee));

				foreach ( $employee_commitments as $commitment ) {
					$this->createNewStudyHolliday($this->month_set_id, (int)$data->employee, (int)$commitment->id, $data->date_from, $data->date_to, $data->from_halfday , $data->to_halfday, $data->note);
				}
			}
			else{
				$this->createNewStudyHolliday($this->month_set_id, (int)$data->employee, (int)$data->commitment_id, $data->date_from, $data->date_to, $data->from_halfday , $data->to_halfday, $data->note);			}

			$this->presenter->flashMessage('Uloženo');
			$this->presenter->redirect('this');

		}


	}

	protected function createNewStudyHolliday($month_set_id, $employee_id, $commitment_id, $date_from, $date_to, $from_halfday = false, $to_halfday = false, $note = null )
	{
		$entity = new MonthSetStudyHolliday();

		$entity->setEmployee( $this->EmployeeModel->find((int)$employee_id));

		$entity->setDate_from( new \Nette\Utils\DateTime($date_from) );
		$entity->setDate_to( new \Nette\Utils\DateTime($date_to) );
		$entity->setFrom_halfday( $from_halfday );
		$entity->setTo_halfday( $to_halfday );

		$commitment_entity = $this->CommitmentModel->find((int)$commitment_id);

		$entity->setCommitment( $commitment_entity );

		$month_set_entity = $this->MonthSetModel->find((int)$month_set_id);

		$entity->setMonthSet( $month_set_entity );
		$entity->setNote($note);

		$this->MonthSetStudyHollidayModel->save($entity);

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