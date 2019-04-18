<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 23:04
 */

namespace App\AdminModule\Presenters;


use App\Component\ItemTypes\Form\IItemTypeFormFactory;
use App\Model\ItemTypesModel;

class ItemTypesPresenter extends BasePresenter
{
	/**
	 * @var ItemTypesModel
	 * @inject
	 */
	public $itemTypesModel;

	/**
	 * @var IItemTypeFormFactory
	 * @inject
	 */
	public $itemTypeFormFactory;

	public function createComponentItemTypeForm()
	{
		return $this->itemTypeFormFactory->create();
	}

	public function actionDefault()
	{
		$this->template->itemTypes = $this->itemTypesModel->getList();
	}

	public function actionAddItemType()
	{

	}

	public function actionEditItemType( $id )
	{
		$this['itemTypeForm']->setId($id);
	}
	
	public function handleDeleteItemType( $id )
	{
		$itemType = $this->itemTypesModel->find($id);
		$this->itemTypesModel->delete($itemType);
		$this->redirect('this');
	}
}