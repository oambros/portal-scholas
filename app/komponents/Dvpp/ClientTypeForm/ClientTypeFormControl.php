<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Gdpr\Form;


use App\Model\ClientTypeModel;
use App\Model\Entity\ClientType;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class ClientTypeFormControl extends Control
{
	/**
	 * @var ClientTypeModel
	 */
	protected $clientTypeModel;

	/**
	 * @var integer
	 */
	protected $id = false;


	public function __construct(ClientTypeModel $clientTypeModel)
	{
		$this->clientTypeModel = $clientTypeModel;
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
			$form->setDefaults($this->clientTypeModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		if($this->id) {
			$type = $this->clientTypeModel->find($this->id);
		}
		else {
			$type = new ClientType();
		}

		$type->setName( $data->name );
		$type->setNote( $data->note );

		if( $this->gdprSubejctTypeModel->save($type) ) {
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