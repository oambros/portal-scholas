<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 27.03.2019
 * Time: 22:58
 */

namespace App\FrontModule\Presenters;


use App\Component\Accounter\Form\IMonthSetStudyHollidayFormFactory;
use App\Model\MonthSetStudyHollidayModel;

final class MonthSetStudyHollidaysPresenter extends BaseHollidays
{

	/**
	 * @var MonthSetStudyHollidayModel
	 * @inject
	 */
	public $monthSetStudyHollidaysModel;

	/**
	 * @var IMonthSetStudyHollidayFormFactory
	 * @inject
	 */
	public $monthSetStudyHollidaysFormFactory;

	public function createComponentForm()
	{
		$control = $this->monthSetStudyHollidaysFormFactory->create();

		$control->setMonthSetId($this->m_set_id);

		return $control;
	}

	public function actionDefault( $m_set_id )
	{
		parent::actionDefault( (int)$m_set_id );
		$this->template->hollidays = $this->month_set->study_hollidays;
		$this->addBreadcrumb('Studijní volno', 'this');

	}

	public function handleDelete( $id )
	{
		$holliday = $this->monthSetStudyHollidaysModel->find((int)$id);
		$this->monthSetStudyHollidaysModel->delete( $holliday );
		$this->flashMessage('Smazáno', 'info');
		$this->redirect('this');
	}
}