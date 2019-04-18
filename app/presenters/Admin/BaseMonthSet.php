<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 14.04.2019
 * Time: 20:38
 */

namespace App\AdminModule\Presenters;


use App\Model\Entity\MainSubject;
use App\Model\ExtraPayModel;
use App\Model\MainSubjectModel;
use App\Model\MonthSetHollidayModel;
use App\Model\MonthSetModel;

abstract class BaseMonthSet extends BasePresenter
{
	/**
	 * @var MonthSetModel
	 * @inject
	 */
	public $monthSetModel;

	/**
	 * @var MonthSetHollidayModel
	 * @inject
	 */
	public $monthSetHollidayModel;

	/**
	 * @var ExtraPayModel
	 * @inject
	 */
	public $extraPayModel;

	/**
	 * @var MainSubjectModel
	 * @inject
	 */
	public $mainSubjectModel;

	/**
	 * @var MainSubject
	 */
	protected $main_subject = null;

	/**
	 * BaseMonthSet constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Seznam subjektů', 'MainSubject:default');
	}

	public function actionAddMonthSet( $id  )
	{
		$this->main_subject = $this->mainSubjectModel->find((int)$id);
		if( !$this->main_subject ) {
			$this->error('Subjekt nenalezen');
			$this->redirect('MainSubject:default');
		}
	}
}