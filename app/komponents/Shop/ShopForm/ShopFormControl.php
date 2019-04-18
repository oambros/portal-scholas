<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 11:56
 */

namespace App\Component\Shop\Form;


use App\Model\Entity\ShopEntity;
use App\Model\ShopModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class ShopFormControl extends Control
{
	/**
	 * @var ShopModel
	 */
	protected $shopModel;

	/**
	 * @var integer
	 */
	protected $id;

	/**
	 * ShopFormControl constructor.
	 * @param ShopModel $shopModel
	 */
	public function __construct( ShopModel $shopModel )
	{
		$this->shopModel = $shopModel;
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
		$form = new Form();

		$form->addText('name', 'Jméno:');
		$form->addText('url', 'URL:');


		if( $this->id ) {
			$form->setDefaults($this->shopModel->find($this->id, true));
		}

		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'onSubmit');
		return $form;
	}

	public function onSubmit( Form $form )
	{
		$data = $form->getValues();
		if($this->id) {
			$shop = $this->shopModel->find($this->id);
		}
		else {
			$shop = new ShopEntity();
		}

		$shop->setName( $data->name );
		$shop->setUrl( $data->url );


		if($this->shopModel->save( $shop )) {
			$this->presenter->flashMessage('Upraveno');
		}

		$this->presenter->redirect('Shop:default');

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->render();
	}

}