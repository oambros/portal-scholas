<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 08.01.2018
 * Time: 22:23
 */

namespace App\AdminModule\Presenters;

use App\Component\Inventory\Form\IInventoryItemFormFactory;
use App\Model\InventoryItemsModel;

class InventoryPresenter extends BasePresenter
{
	/**
	 * @var InventoryItemsModel
	 * @inject
	 */
	public $inventoryItemsModel;

	/**
	 * @var IInventoryItemFormFactory
	 * @inject
	 */
	public $inventoryItemFormFactory;

	public function createComponentInventoryItemForm()
	{
		return $this->inventoryItemFormFactory->create();
	}

	public function actionAddInventoryItem()
	{

	}

	public function handleDeleteInventoryItem($id)
	{

	}

	public function actionEditInventoryItem( $id )
	{
		$this['inventoryItemForm']->setId($id);
	}
	public function renderDefault()
	{
		$this->template->inventoryItems = $this->inventoryItemsModel->getList();
	}

}