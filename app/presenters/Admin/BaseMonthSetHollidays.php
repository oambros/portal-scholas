<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.12.2018
 * Time: 22:29
 */

namespace App\AdminModule\Presenters;


use App\Model\Entity\MonthSet;
use App\Model\MonthSetModel;

class BaseMonthSetHollidays extends BasePresenter
{
	/**
	 * @var MonthSetModel
	 * @inject
	 */
	public $monthSetModel;

	/**
	 * @var MonthSet
	 */
	public $month_set;

	public function actionDefault( $mset )
	{
		if( !$mset ) {
			$this->errorFlash('Není zadáno id setu!');
			$this->redirect('MainSubject:default');
		}

		if(!$this->month_set = $this->monthSetModel->find((int)$mset) ) {
			$this->errorFlash('Id setu nenalezeno');
			$this->redirect('MainSubject:default');
		}

		$this->template->month_set = $this->month_set;

	}
}