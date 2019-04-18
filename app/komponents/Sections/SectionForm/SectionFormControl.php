<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 24.10.2018
 * Time: 14:47
 */

namespace App\Component\Section\Forms;


use App\Model\Entity\SectionAllowed;
use App\Model\SectionAllowedModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class SectionFormControl extends Control
{
	protected $id = false;

	/**
	 * @var SectionAllowedModel
	 */
	protected $sectionAllowedModel;

	/**
	 * SectionFormControl constructor.
	 * @param SectionAllowedModel $sectionAllowedModel
	 */
	public function __construct( SectionAllowedModel $sectionAllowedModel )
	{
		$this->sectionAllowedModel = $sectionAllowedModel;
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
			->addText('name', 'Jmeno:')
			->addRule(Form::FILLED, 'mMusíte zadat jmeno');

		$form
			->addText('presenter_name', 'Presenter sekce');

		$form
			->addTextArea('note', 'Poznámka');

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');

		if( $this->id )
			$form->setDefaults($this->sectionAllowedModel->find($this->id, true));

		return $form;
	}

	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		if($this->id) {
			$section = $this->sectionAllowedModel->find($this->id);
		}
		else {
			$section = new SectionAllowed();
		}

		$section->setName( $data->name );
		$section->setNote( $data->note );
		$section->setPresenter_name( $data->presenter_name );

		if( $this->sectionAllowedModel->save($section) ) {
			$this->presenter->flashMessage('Uloženo');
		}
	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}