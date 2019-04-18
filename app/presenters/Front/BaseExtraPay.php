<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 15.04.2019
 * Time: 1:06
 */

namespace App\FrontModule\Presenters;


use App\Model\Entity\MonthSet;
use App\Model\ExtraPayModel;
use App\Model\ExtraPayTypeModel;
use App\Model\MonthSetModel;

abstract class BaseExtraPay extends BasePresenter
{
	/**
	 * @var MonthSet
	 */
	protected $month_set = null;

	/**
	 * @var integer null
	 */
	protected $extra_pay_type_id = null;

	/**
	 * @var MonthSetModel
	 * @inject
	 */
	public $monthSetModel;

	/**
	 * @var ExtraPayModel
	 * @inject
	 */
	public $extraPayModel;

	/**
	 * @var ExtraPayTypeModel
	 * @inject
	 */
	public $extraPayTypeModel;

	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Měsíční sety', 'MonthSet:default');

	}


	public function actionDefault( $mset )
	{
		if (!$mset) {
			$this->errorFlash('Není zadáno id setu!');
			$this->redirect('MainSubject:default');
		}

		if (!$this->month_set = $this->monthSetModel->find((int)$mset)) {
			$this->errorFlash('Id setu nenalezeno');
			$this->redirect('MainSubject:default');
		}

		if( $this->month_set->locked ){
			$this->errorFlash('Set nelze upravit, je uzamčet');
			$this->infoFlash('Pokud si přejete odemčít tento měsíc, kontaktujte svého mzdového účetního.');
			$this->redirect('MonthSet:default');
		}


		$this->template->month_set = $this->month_set;
		$this->template->main_subject = $this->month_set->main_subject;
		$this->template->main_subject_extra_pay_type = $this->getExtraPayTypes($this->month_set->main_subject->main_subject_extra_pay_type, $this->month_set);

	}

	/**
	 * @param $type
	 * @param MonthSet $monthSet
	 * @return array
	 */
	protected function getExtraPayTypes($type, MonthSet $monthSet)
	{
		$array = [];

		foreach ($type->ept as $ept) {
			$array[$ept->id]['count'] = $this->extraPayModel->getCountPaysByEptMset($ept->id, $monthSet);
			$array[$ept->id]['data'] = $ept;
		}

		return $array;
	}

}