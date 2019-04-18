<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 26.03.2019
 * Time: 15:06
 */

namespace App\AdminModule\Presenters;


class BaseEmployee extends BasePresenter
{
	public function beforeRender(  ) {
		parent::beforeRender();
	}

	public function actionDefault()
	{
		$this->addBreadcrumb('Zaměstnanci' );
	}

}