<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:48
 */

namespace App\FrontModule\Presenters;

use App\Component\Accounter\Form\IMonthSetHollidayFormFactory;
use App\Model\MonthSetHollidayModel;

class MonthSetHollidaysPresenter extends BaseHollidays
{
	/**
	 * @var IMonthSetHollidayFormFactory
	 * @inject
	 */
	public $monthSetHollidayFormFactory;

	/**
	 * @var MonthSetHollidayModel
	 * @inject
	 */
	public $monthSetHollidayModel;

	/**
	 * @return \App\Component\Accounter\Form\MonthSetHollidayFormControl
	 */
	public function createComponentForm()
	{
		$control = $this->monthSetHollidayFormFactory->create();

		$control->setMonthSetId( $this->m_set_id );

		return $control;
	}

	public function actionDefault( $m_set_id )
	{
		parent::actionDefault( $m_set_id );
		$this->template->hollidays = $this->month_set->hollidays;
		$this->addBreadcrumb('Dovolená', 'this');
	}

	public function handleDelete( $id )
	{
		$holliday = $this->monthSetHollidayModel->find((int)$id);
		$this->monthSetHollidayModel->delete( $holliday );
		$this->flashMessage('Smazáno', 'info');
		$this->redirect('this');
	}
}