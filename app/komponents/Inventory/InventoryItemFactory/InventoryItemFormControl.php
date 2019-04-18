<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 23:44
 */

namespace App\Component\Inventory\Form;


use App\Model\Entity\InventoryItemEntity;
use App\Model\InventoryItemsModel;
use App\Model\ItemTypesModel;
use App\Model\ManufacturerModel;
use App\Model\ShopModel;
use App\Model\UsersModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class InventoryItemFormControl extends Control
{
	/**
	 * @var InventoryItemsModel
	 */
	protected $inventoryItemsModel;

	/**
	 * @var ItemTypesModel
	 */
	protected $itemTypesModel;

	/**
	 * @var UsersModel
	 */
	protected $usersModel;

	/**
	 * @var ShopModel
	 */
	protected $shopModel;

	/**
	 * @var ManufacturerModel
	 */
	protected $manufactorerModel;

	/**
	 * @var integer
	 */
	protected $id = false;

	public function __construct(
								InventoryItemsModel $inventoryItemsModel,
								ItemTypesModel $itemTypesModel,
								UsersModel $usersModel,
								ShopModel $shopModel,
								ManufacturerModel $manufacturerModel
			)
	{
		$this->inventoryItemsModel = $inventoryItemsModel;
		$this->itemTypesModel = $itemTypesModel;
		$this->usersModel = $usersModel;
		$this->shopModel = $shopModel;
		$this->manufactorerModel = $manufacturerModel;
	}

	/**
	 * @param integer $id
	 */
	public function setId( $id )
	{
		$this->id = (int)$id;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form->addText('name', 'Název')
			->addRule(Form::FILLED, 'Musíte zadat název');

		$form->addText('code', 'Kód');
			//->addRule(Form::FILLED, 'Musíte vyplnit kód');

		$form->addSelect('manufacturer', 'Výrobce', $this->manufactorerModel->getSelectList());

		$form->addSelect('shop', 'Obchod', $this->shopModel->getSelectList());

		$form->addSelect('item_type', 'Typ položky', $this->itemTypesModel->getSelectList());

		if( $this->id ) {
			$form->setDefaults($this->inventoryItemsModel->find($this->id, true));
		}

		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'onSubmit');

		return $form;
	}

	/**
	 * @param Form $form
	 * @throws \Nette\Application\AbortException
	 */
	public function onSubmit( Form $form )
	{
		$data = $form->getValues();
		if($this->id) {
			$item = $this->inventoryItemsModel->find($this->id);
		}
		else {
			$item = new InventoryItemEntity();
		}

		$item->setName( $data->name );

		$code = $data->code ? $data->code : $this->inventoryItemsModel->generateCode($item);

		$item->setCode( $code );

		if( $data->manufacturer )
			$item->setManufacturer( $this->manufactorerModel->find($data->manufacturer) );

		if( $data->shop )
		$item->setShop( $this->shopModel->find($data->shop) );

		if( $data->item_type )
			$item->setItem_type( $this->itemTypesModel->find($data->item_type) );


		if($this->inventoryItemsModel->save( $item )) {
			$this->presenter->flashMessage('Upraveno');
		}

		$this->presenter->redirect('Inventory:default');

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->render();
	}


}