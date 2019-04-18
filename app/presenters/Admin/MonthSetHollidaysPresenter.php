<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:48
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\IMonthSetHollidayFormFactory;
use App\Model\MonthSetHollidayModel;
use App\Model\MonthSetModel;
use Nette\Application\UI\Form;

class MonthSetHollidaysPresenter extends BaseMonthSetHollidays
{
	/**
	 * @var MonthSetHollidayModel
	 * @inject
	 */
	public $monthSetHollidayModel;

	/**
	 * @var IMonthSetHollidayFormFactory
	 * @inject
	 */
	public $monthSetHollidayFactory;

	public function createComponentForm()
	{   $control = $this->monthSetHollidayFactory->create();
		return $control;
	}

	public function handleDelete( $id )
	{
		$holliday = $this->monthSetHollidayModel->find((int)$id);
		$this->monthSetHollidayModel->delete( $holliday );
		$this->flashMessage('Smazáno', 'info');
		$this->redirect('this');
	}

	public function actionDefault($mset_id)
	{
		parent::actionDefault((int)$mset_id);
		$this['form']->setMonthSetId((int)$mset_id);
		$this->template->hollidays = $this->month_set->hollidays;
	}
}