<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;

use App\Model\EmployeeModel;
use App\Model\Entity\Employee;
use App\Model\MainSubjectModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class EmployeeFormControl extends Control
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
	 * @var integer
	 */
	protected $id = false;

	/**
	 * @var integer
	 */
	protected $main_subject_id;

	public $onSaveEmployee = [];

	public function __construct(EmployeeModel $EmployeeModel, MainSubjectModel $mainSubjectModel)
	{
		$this->EmployeeModel= $EmployeeModel;
		$this->MainSubjectModel = $mainSubjectModel;
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
	public function setSubjectId($id)
	{
		$this->main_subject_id = (int)$id;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form
			->addText('oscis', 'oscis');

		$form
			->addText('f_name', 'Jméno')
			->addRule(Form::FILLED, 'Musíte zadat jméno');

		$form
			->addText('l_name', 'Přijmení')
			->addRule(Form::FILLED, 'Musíte zadat přijmení');


		$form
			->addText('id_num', 'Rodné číslo');

		$form
			->addTextArea('note', 'Popis');

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');

		if( $this->id )
			$form->setDefaults($this->EmployeeModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		if($this->id) {
			$entity = $this->EmployeeModel->find($this->id);
		}
		else {
			$entity = new Employee();
			$entity->setMain_subject($this->MainSubjectModel->find($this->main_subject_id));

		}

		$entity->setOscis( $data->oscis);
		$entity->setF_name( $data->f_name);
		$entity->setL_name( $data->l_name);
		$entity->setid_num( $data->id_num);
		$entity->setNote( $data->note );



		if( $this->EmployeeModel->save($entity) ) {
			$this->onSaveEmployee($entity);
		}

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}