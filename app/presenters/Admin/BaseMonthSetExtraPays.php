<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 27.12.2018
 * Time: 14:08
 */

namespace App\AdminModule\Presenters;


use App\Model\Entity\MonthSet;
use App\Model\ExtraPayModel;
use App\Model\MonthSetModel;

class BaseMonthSetExtraPays extends BasePresenter
{
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
	 * @var MonthSet
	 */
	public $month_set;

	public function actionDefault($mset)
	{
		if (!$mset) {
			$this->errorFlash('Není zadáno id setu!');
			$this->redirect('MainSubject:default');
		}

		if (!$this->month_set = $this->monthSetModel->find((int)$mset)) {
			$this->errorFlash('Id setu nenalezeno');
			$this->redirect('MainSubject:default');
		}

		$this->template->month_set = $this->month_set;
		$this->template->main_subject = $this->month_set->main_subject;
		$this->template->main_subject_extra_pay_type = $this->getExtraPayTypes($this->month_set->main_subject->main_subject_extra_pay_type, $this->month_set);

	}

	protected function getExtraPayTypes($type, MonthSet $monthSet)
	{
		$array = [];

		foreach ($type->ept as $ept) {
			$array[$ept->id]['count'] = $this->extraPayModel->getCountPaysByEptMset($ept->id, $monthSet);
			$array[$ept->id]['data'] = $ept;
		}

		return $array;
	}

	/**
	 * @param $extra_pay_id
	 * @throws \Nette\Application\AbortException
	 */
	public function handleDelete( $extra_pay_id ) {
		$extra_pay = $this->extraPayModel->find((int)$extra_pay_id);
		if( !$extra_pay ) {
			$this->errorFlash('Příplatek nenalezen');
		}
		else {
			$this->extraPayModel->delete($extra_pay);
			$this->infoFlash('Příplatek smazán');
		}
		$this->redirect('this');
	}
}