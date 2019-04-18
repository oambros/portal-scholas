<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 28.03.2019
 * Time: 0:24
 */

namespace App\FrontModule\Presenters;


use App\Component\Accounter\Form\IMonthSetDoctorHollidayFormFactory;
use App\Model\MonthSetDoctorHolidayModel;

final class MonthSetDoctorHollidaysPresenter extends BaseHollidays
{
	/**
	 * @var IMonthSetDoctorHollidayFormFactory
	 * @inject
	 */
	public $monthSetDoctorHollidayFormFactory;

	/**
	 * @var MonthSetDoctorHolidayModel
	 * @inject
	 */
	public $monthSetDoctorHollidayModel;

	public function createComponentForm() {
		$control = $this->monthSetDoctorHollidayFormFactory->create();

		$control->setMonthSetId( $this->m_set_id );

		return $control;
	}

	public function actionDefault( $m_set_id )
	{
		parent::actionDefault( $m_set_id );
		$this->template->hollidays = $this->month_set->doctor_hollidays;
		$this->addBreadcrumb('Návštěva lékaře', 'this');


	}

	public function handleDelete( $id )
	{
		$holliday = $this->monthSetDoctorHollidayModel->find((int)$id);
		$this->monthSetDoctorHollidayModel->delete( $holliday );
		$this->flashMessage('Smazáno', 'info');
		$this->redirect('this');
	}
}