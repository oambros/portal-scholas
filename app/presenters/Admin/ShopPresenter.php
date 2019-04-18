<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 11:47
 */

namespace App\AdminModule\Presenters;


use App\Component\Shop\Form\IShopFormFactory;
use App\Component\Shop\Form\ShopFormControl;
use App\Model\ShopModel;

class ShopPresenter extends BasePresenter
{
	/**
	 * @var ShopModel
	 * @inject
	 */
	public $shopModel;

	/**
	 * @var IShopFormFactory
	 * @inject
	 */
	public $shopFormFactory;

	public function createComponentShopForm()
	{
		return $this->shopFormFactory->create();
	}

	public function actionEditShop($id)
	{
		$this['shopForm']->setId($id);
	}

	public function actionAddShop()
	{
		
	}

	public function handleDeleteShop( $id )
	{
		$shop = $this->shopModel->find($id);
		$this->shopModel->delete($shop);
		$this->redirect('this');
	}

	public function actionDefault()
	{
		$this->template->shops = $this->shopModel->getList();
	}
}