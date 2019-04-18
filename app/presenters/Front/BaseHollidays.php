<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 27.03.2019
 * Time: 22:30
 */

namespace App\FrontModule\Presenters;


use App\Model\Entity\MonthSet;
use App\Model\MonthSetModel;

class BaseHollidays extends BasePresenter
{
	protected $m_set_id = null;

	/**
	 * @var MonthSet
	 */
	protected $month_set;

	/**
	 * @var MonthSetModel
	 * @inject
	 */
	public $monthSetModel;

	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Měsíční sety', 'MonthSet:default');
	}

	public function actionDefault( $m_set_id )
	{

		$this->m_set_id = (int)$m_set_id;
		$this->month_set = $this->monthSetModel->find($this->m_set_id);
		$this->template->month_set = $this->month_set;

		if( $this->month_set->locked ){
			$this->errorFlash('Set nelze upravit, je uzamčen');
			$this->infoFlash('Pokud si přejete odemčít tento měsíc, kontaktujte svého mzdového účetního.');
			$this->redirect('MonthSet:default');
		}
	}

	public function beforeRender()
	{
		parent::beforeRender();


	}
}