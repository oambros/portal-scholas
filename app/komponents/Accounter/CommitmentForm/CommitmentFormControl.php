<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;


use App\Model\EmployeeModel;
use App\Model\Entity\ClientType;
use App\Model\CommitmentModel;
use App\Model\Entity\Commitment;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class CommitmentFormControl extends Control
{
	/**
	 * @var CommitmentModel
	 */
	protected $CommitmentModel;

	/**
	 * @var EmployeeModel
	 */
	protected $EmployeeModel;

	public $onSaveNew = [];

	/**
	 * @var integer
	 */
	protected $id = false;

	/**
	 * @var integer
	 */
	protected $employee_id = false;

	public function __construct(CommitmentModel $CommitmentModel, EmployeeModel $employeeModel)
	{
		$this->CommitmentModel= $CommitmentModel;
		$this->EmployeeModel = $employeeModel;
	}

	/**
	 * @param $id
	 */
	public function setEmployeeId($id)
	{
		$this->employee_id = (int)$id;
	}

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form
			->addText('name', 'Název')
			->addRule(Form::FILLED, 'Musíte zadat název');

		$form
			->addText('cicin', 'cicin')
			->addRule(Form::FILLED, 'Musíte vyplnit číslo úvazku (cicin)');

		$form
			->addText('pracv', 'pracv');

		$form
			->addText('num_free_days', 'Počet dní dovolené');

		$form
			->addTextArea('note', 'Popis');

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');

		if( $this->id )
			$form->setDefaults($this->CommitmentModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		if($this->id) {
			$entity = $this->CommitmentModel->find($this->id);
			$this->employee_id = $this->EmployeeModel->find($entity->employee->getId());
		}
		else {
			$entity = new Commitment();
		}

		$entity->setName( $data->name );
		$entity->setNote( $data->note );
		$entity->setPracv( $data->pracv);
		$entity->setCicin( $data->cicin);
		$entity->setNum_free_days( $data->num_free_days);
		$entity->setEmployee( $this->EmployeeModel->find( $this->employee_id ) );

		if( $this->CommitmentModel->save($entity) ) {
			$this->onSaveNew( $entity );
		}

	}

	public function render()
	{
		$template = $this->createTemplate();
		if( $this->employee_id )
			$template->employee = $this->EmployeeModel->find($this->employee_id);
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}