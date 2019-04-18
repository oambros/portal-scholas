<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;

use App\Model\Entity\Financing;
use App\Model\FinancingModel;
use App\Model\MainSubjectModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class FinancingFormControl extends Control
{
	/**
	 * @var FinancingModel
	 */
	protected $FinancingModel;

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

	public $onNewSave = [];


	public function __construct(FinancingModel $financingModel, MainSubjectModel $mainSubjectModel)
	{
		$this->FinancingModel= $financingModel;
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
			->addText('name', 'Název')
			->addRule(Form::FILLED, 'Musíte zadat jméno');;

		$form
			->addText('note', 'Poznámka');


		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');

		if( $this->id )
			$form->setDefaults($this->FinancingModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		if($this->id) {
			$entity = $this->FinancingModel->find($this->id);
		}
		else {
			$entity = new Financing();
		}
		$entity->setMain_subject($this->MainSubjectModel->find($this->main_subject_id));

		$entity->setName( $data->name );
		$entity->setNote( $data->note );

		if( $this->FinancingModel->save($entity) ) {
			$this->onNewSave( $entity );
		}
	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}