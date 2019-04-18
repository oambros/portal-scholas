<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16.01.2018
 * Time: 12:51
 */

namespace App\Component\ItemTypes\Form;

use App\Model\Entity\ItemTypesEntity;
use App\Model\Entity\ManufacturerEntity;
use App\Model\ItemTypesModel;
use App\Model\ManufacturerModel;
use Nette\Application\UI;

/**
 * Class ItemTypeFormControl
 * @package App\Component\ItemTypes\Form
 */
class ItemTypeFormControl extends UI\Control
{
	protected $id;

	/**
	 * @var ItemTypesModel
	 */
	protected $itemTypesModel;

	public function __construct( ItemTypesModel $itemTypesModel )
	{
		$this->itemTypesModel = $itemTypesModel;
	}

	/**
	 * @param integer $id
	 */
	public function setId( $id )
	{
		$this->id = (int)$id;
	}

	public function createComponentForm()
	{
		$form = new UI\Form();

		$form->addText('name', 'Jméno:')
			->addRule(UI\Form::FILLED, 'Zadejte jméno');

		$form->addText('code_part', 'Část kodu:')
			->addRule(UI\Form::FILLED, 'Zadejte část kódu');

		if( $this->id ) {
			$form->setDefaults($this->itemTypesModel->find($this->id, true));
		}

		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'onSubmit');
		return $form;
	}

	public function onSubmit( UI\Form $form )
	{
		$data = $form->getValues();
		if($this->id) {
			$itemType = $this->itemTypesModel->find($this->id);
		}
		else {
			$itemType = new ItemTypesEntity();
		}

		$itemType->setName( $data->name );
		$itemType->setCode_part( $data->code_part );


		if($this->itemTypesModel->save( $itemType )) {
			$this->presenter->flashMessage('Upraveno');
		}

		$this->presenter->redirect('ItemTypes:default');

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->render();
	}

}