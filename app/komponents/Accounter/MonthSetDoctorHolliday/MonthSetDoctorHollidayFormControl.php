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
use App\Model\Entity\MonthSet;
use App\Model\Entity\MonthSetDoctorHolliday;
use App\Model\MainSubjectModel;
use App\Model\MonthSetDoctorHolidayModel;
use App\Model\MonthSetModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class MonthSetDoctorHollidayFormControl extends Control
{
	/**
	 * @var MonthSetDoctorHolidayModel
	 */
	protected $MonthSetDoctorHolidayModel;

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
	 * @var MonthSetDoctorHolliday
	 */
	protected $month_set_doctor_holliday_entity;

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
	 * MonthSetDoctorHollidayFormControl constructor.
	 * @param CommitmentModel $commitmentModel
	 * @param MonthSetModel $monthSetModel
	 * @param MonthSetDoctorHolidayModel $monthSetDoctorHollidayModel
	 * @param MainSubjectModel $mainSubjectModel
	 * @param EmployeeModel $employeeModel
	 */
	public function __construct( CommitmentModel $commitmentModel, MonthSetModel $monthSetModel, MonthSetDoctorHolidayModel $monthSetDoctorHollidayModel, MainSubjectModel $mainSubjectModel, EmployeeModel $employeeModel )
	{
		$this->MonthSetModel = $monthSetModel;
		$this->MonthSetDoctorHolidayModel = $monthSetDoctorHollidayModel;
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
		$this->month_set_entity = $this->month_set_doctor_holliday_entity->getMonth_set();
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
			->addSelect('commitment', 'Činnost:')
			->setPrompt('Vyber činnost')
			->setHtmlAttribute('class', 'commitment-select chosen-select');

		$form->addHidden('commitment_id')->setHtmlAttribute('id', 'commitment-id');

		$form
			->addText('hours', 'Počet hodin')
			->addRule(Form::FILLED, 'Musíte zadat počet hodin!')
			->setHtmlAttribute('class', 'hours')
			->setHtmlAttribute('autocomplete', 'off')
			->setHtmlAttribute('placeholder', 'Počet hodin');


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

		if( $data->commitment_id == 'x' ) {
				$employee_commitments = $this->CommitmentModel->getCommitmentsByEmployee((int)($data->employee));

				foreach ( $employee_commitments as $commitment ) {
					$this->createNewDoctorHolliday($this->month_set_id, (int)$data->employee, (int)$commitment->id, (int)$data->hours, $data->note);
				}
		}
		else{
				$this->createNewDoctorHolliday($this->month_set_id, (int)$data->employee, (int)$data->commitment_id, (int)$data->hours, $data->note);
		}

		$this->presenter->flashMessage('Uloženo');
		$this->presenter->redirect('this');

	}

	protected function createNewDoctorHolliday($month_set_id, $employee_id, $commitment_id, $hours, $note = null )
	{
		$entity = new MonthSetDoctorHolliday();

		$entity->setEmployee( $this->EmployeeModel->find((int)$employee_id));

		$entity->setHours( (int)$hours );

		$commitment_entity = $this->CommitmentModel->find((int)$commitment_id);

		$entity->setCommitment( $commitment_entity );

		$month_set_entity = $this->MonthSetModel->find((int)$month_set_id);

		$entity->setMonthSet( $month_set_entity );
		$entity->setNote($note);

		$this->MonthSetDoctorHolidayModel->save($entity);

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