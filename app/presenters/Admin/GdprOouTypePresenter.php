<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 04.02.2018
 * Time: 1:13
 */

namespace App\AdminModule\Presenters;


use App\Component\Gdpr\Form\IGdprOouTypeFormFactory;
use App\Model\GdprOouTypeModel;

class GdprOouTypePresenter extends BasePresenter
{
	/**
	 * @var GdprOouTypeModel
	 * @inject
	 */
	public $gdprOouTypeModel;

	/**
	 * @var IGdprOouTypeFormFactory
	 * @inject
	 */
	public $gdprOouTypeFactory;

	/**
	 * @return \App\Component\Gdpr\Form\GdprOouTypeFormControl
	 */
	public function createComponentOouTypeForm()
	{
		return $this->gdprOouTypeFactory->create();
	}

	public function actionAddOouType()
	{

	}

	/**
	 * @param $id
	 */
	public function actionEditOouType( $id )
	{
		$this['oouTypeForm']->setId((int)$id);
	}

	public function actionDefault()
	{
		$this->template->oou_types = $this->gdprOouTypeModel->getList();
	}
}