<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.12.2018
 * Time: 19:08
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\IMonthSetStudyHollidayFormFactory;
use App\Model\MonthSetStudyHollidayModel;

class MonthSetStudyHollidaysPresenter extends BaseMonthSetHollidays
{
	/**
	 * @var IMonthSetStudyHollidayFormFactory
	 * @inject
	 */
	public $monthSetStudyHollidaysFactory;

	/**
	 * @var MonthSetStudyHollidayModel
	 * @inject
	 */
	public $monthSetStudyHollidayModel;

	/**
	 * @return \App\Component\Accounter\Form\MonthSetStudyHollidayFormControl
	 */
	public function createComponentForm()
	{
		return $this->monthSetStudyHollidaysFactory->create();
	}

	public function handleDelete( $id )
	{
		$holliday = $this->monthSetStudyHollidayModel->find((int)$id);
		$this->monthSetStudyHollidayModel->delete( $holliday );
		$this->flashMessage('Smazáno', 'info');
		$this->redirect('this');
	}

	public function actionDefault($mset_id)
	{
		parent::actionDefault((int)$mset_id);
		$this['form']->setMonthSetId((int)$mset_id);
		$this->template->hollidays = $this->month_set->study_hollidays;
	}

}