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
use App\Model\Entity\ExtraPay;
use App\Model\Entity\ExtraPayType;
use App\Model\Entity\MainSubject;
use App\Model\Entity\MonthSet;
use App\Model\Entity\MonthSetHolliday;
use App\Model\ExtraPayModel;
use App\Model\ExtraPayTypeModel;
use App\Model\FinancingModel;
use App\Model\MainSubjectModel;
use App\Model\MonthSetHollidayModel;
use App\Model\MonthSetModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Bridges\FormsLatte\FormMacros;
use Nette\DateTime;

class ExtraPayFormControl extends Control
{

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
	 * @var MonthSetModel
	 */
	protected $MonthSetModel;

	/**
	 * @var ExtraPayModel
	 */
	protected $ExtraPayModel;

	/**
	 * @var ExtraPayTypeModel
	 */
	protected $ExtraPayTypeModel;

	/**
	 * @var FinancingModel
	 */
	protected $FinancingModel;

	/**
	 * @var MonthSet
	 */
	protected $month_set_entity;

	/**
	 * @var ExtraPayType
	 */
	protected $extra_pay_type_entity;

	/**
	 * @var integer
	 */
	protected $id = false;

	/**
	 * @var integer
	 */
	protected $extra_pay_type_id = false;

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
	 * @var integer
	 * //$base_type = array(1 => 'Hodinový', 2 => 'Částkou', 3 => 'Částka i hodiny')
	 */
	protected $base_type = 3;

	/**
	 * ExtraPayFormControl constructor.
	 * @param ExtraPayTypeModel $extraPayTypeModel
	 * @param ExtraPayModel $extraPayModel
	 * @param EmployeeModel $EmployeeModel
	 * @param MainSubjectModel $MainSubjectModel
	 * @param CommitmentModel $CommitmentModel
	 * @param MonthSetModel $monthSetModel
	 * @param FinancingModel $financingModel
	 */
	public function __construct(ExtraPayTypeModel $extraPayTypeModel, ExtraPayModel $extraPayModel, EmployeeModel $EmployeeModel, MainSubjectModel $MainSubjectModel, CommitmentModel $CommitmentModel, MonthSetModel $monthSetModel, FinancingModel $financingModel)
	{
		$this->ExtraPayModel = $extraPayModel;
		$this->ExtraPayTypeModel = $extraPayTypeModel;
		$this->EmployeeModel = $EmployeeModel;
		$this->MainSubjectModel = $MainSubjectModel;
		$this->CommitmentModel = $CommitmentModel;
		$this->MonthSetModel = $monthSetModel;
		$this->FinancingModel = $financingModel;
	}


	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
	}

	/**
	 * @param $id
	 */
	public function setExtraPayTypeId( $id )
	{
		$this->extra_pay_type_id = (int)$id;
		$this->extra_pay_type_entity = $this->ExtraPayTypeModel->find($this->extra_pay_type_id);
		$this->base_type = $this->extra_pay_type_entity->base_type;
	}

	/**
	 * @param $id ind
	 */
	protected function setEmployee( $id )
	{
		$this->employee_id = (int)$id;
	}

	/**
	 * @param $id int
	 */
	public function setMonthSetId( $id )
	{
		$this->month_set_id = (int)$id;
		$this->month_set_entity = $this->MonthSetModel->find($this->month_set_id);
	}

	/**
	 * @param $id int
	 */
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
		$main_subject = $this->month_set_entity->getMain_subject();

		$form = new Form();

		$form
			->addSelect('employee', 'Zaměstnanec', $this->EmployeeModel->getListByMainSubject($main_subject->getId(), true))
			->setPrompt('Vyber zaměstnance')
			->setHtmlAttribute('class', 'extra-pay-form-employee-select chosen-select');


		$form
			->addSelect('commitment', 'Úvazek:')
			->setPrompt('Vyber činnost')
			->setHtmlAttribute('class', 'commitment-select chosen-select');

		$form
			->addSelect('financing', 'Zdroj financování:', $main_subject->getFinancingsCheckboxList())
			->setHtmlAttribute('class', 'financing-select chosen-select');


		if($this->base_type == null)
			$form
				->addText('name', 'Název')
				->setRequired('Musíte zadat název prémie')
				->setHtmlAttribute('id', 'form-name');

		$form
			->addHidden('month_set_id')
			->setHtmlAttribute('id', 'month_set_id');

		$form
			->addHidden('employee_id')
			->setHtmlAttribute('id', 'employee_id');

		$form
			->addHidden('commitment_id')
			->setHtmlAttribute('id', 'commitment-id');


		$form
			->addHidden('extra_pay_type_id')
			->setHtmlAttribute('id', 'extra-pay-type-id');

		if( $this->base_type == 2 || $this->base_type == 3 ) {
			$form
				->addText('amount', 'Částka')
				->addRule(Form::NUMERIC, 'Musíte zadat číslo')
				->setRequired('Musíte zadat částku')
				->setHtmlAttribute('id', 'form-amount');
		}

		if( $this->base_type == 1 || $this->base_type == 3) {
			$form
				->addText('hours', 'Hodiny')
				->addRule(Form::NUMERIC, 'Musíte zadat číslo')
				->setRequired('Musíte zadat hodiny')
				->setHtmlAttribute('id', 'form-hours');

		}

		$form
			->addTextArea('note', 'Poznámka k prémii')
			->setHtmlAttribute('id', 'form-note');

		$form
			->addSubmit('submit', 'Ulož')
			->setHtmlAttribute('class', 'submit');

		if( $this->employee_id ) {
			$form['employee']->setDefaultValue((int)$this->employee_id);
			$form['employee_id']->setDefaultValue((int)$this->employee_id);
		}

		if( $this->commitment_id ) {
			$form['commitment']->setDefaultValue((int)$this->commitment_id);
			$form['commitment_id']->setDefaultValue((int)$this->commitment_id);
		}

		if( $this->month_set_id ) {
			$form['month_set_id']->setDefaultValue((int)$this->month_set_id);
		}

		if( $this->extra_pay_type_id ) {
			$form['extra_pay_type_id']->setDefaultValue((int)$this->extra_pay_type_id);
		}

		$form->onSuccess[] = array($this, 'formSubmit');

		return $form;
	}

	/**
	 * @param Form $form
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Nette\Application\AbortException
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		$entity = new ExtraPay();

		(isset($data->name) == true ? $entity->setName( $data->name ) : false );

		(isset($data->amount) == true ? $entity->setAmount( $data->amount ) : false);

		(isset($data->hours) == true ? $entity->setHours( $data->hours) : false);

		$entity->setNote($data->note);

		$entity->setEmployee( $this->EmployeeModel->find((int)$data->employee_id) );
		$entity->setCommitment( $this->CommitmentModel->find((int)$data->commitment_id ));
		$entity->setMonth_set( $this->MonthSetModel->find((int)$data->month_set_id ));
		$entity->setExtra_pay_type( $this->ExtraPayTypeModel->find((int)$data->extra_pay_type_id) );

		($data->financing != null ? $entity->setFinancing($this->FinancingModel->find((int)$data->financing)) : $entity->setFinancing(null));


		if( $this->ExtraPayModel->save($entity) ) {
			$this->presenter->flashMessage('Uloženo', 'info');
			$this->presenter->redirect('this');
		}
		else {
			$this->presenter->flashMessage('Něco se pokazilo', 'error');
		}
	}

	public function handleSetEmployee( $id )
	{
		$this->setEmployee((int)$id);
		if( $this->employee_id ) {
			$employee_commitments = $this->CommitmentModel->getCommitmentsByEmployee((int)$this->employee_id, true);

		}
		else {
			$employee_commitments = array();
		}

		$this['form']['commitment']->setItems($employee_commitments);

		$this->redrawControl('extra-pay-form');

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