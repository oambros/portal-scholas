<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Gdpr\Form;


use App\Model\Entity\GdprSubjectType;
use App\Model\GdprSubjectTypeModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class GdprSubjectTypeFormControl extends Control
{
	/**
	 * @var GdprSubjectTypeModel
	 */
	protected $gdprSubejctTypeModel;

	/**
	 * @var integer
	 */
	protected $id = false;

	/**
	 * GdprSubjectTypeFormControl constructor.
	 * @param GdprSubjectTypeModel $gdprSubjectTypeModel
	 */
	public function __construct(GdprSubjectTypeModel $gdprSubjectTypeModel)
	{
		$this->gdprSubejctTypeModel = $gdprSubjectTypeModel;
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
			->addTextArea('note', 'Popis');

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');

		if( $this->id )
			$form->setDefaults($this->gdprSubejctTypeModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		if($this->id) {
			$type = $this->gdprSubejctTypeModel->find($this->id);
		}
		else {
			$type = new GdprSubjectType();
		}

		$type->setName( $data->name );
		$type->setNote( $data->note );

		if( $this->gdprSubejctTypeModel->save($type) ) {
			$this->presenter->flashMessage('Uloženo');
		}

		$this->presenter->redirect('GdprSubjectType:default');

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}