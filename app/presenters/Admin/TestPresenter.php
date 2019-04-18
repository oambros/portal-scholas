<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.12.2018
 * Time: 10:43
 */

namespace App\AdminModule\Presenters;

use App\Component\Accounter\Form\ICsvUploadFactory;

class TestPresenter extends BasePresenter
{
	/**
	 * @var ICsvUploadFactory
	 * @inject
	 */
	public $csvFormFactory;


	public function actionDefault() {

	}

	public function actionCsvTest() {

	}

	public function createComponentCsvTestForm()
	{
		return $this->csvFormFactory->create();
	}

}