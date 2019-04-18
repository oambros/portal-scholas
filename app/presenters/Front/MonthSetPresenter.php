<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:15
 */

namespace App\FrontModule\Presenters;


use App\Component\Accounter\Form\IExtraPayFormFactory;
use App\Component\Accounter\Form\IMonthSetFormFactory;
use App\Component\Accounter\Form\IMonthSetNoteFormFactory;
use App\Model\ClientUserModel;
use App\Model\Entity\MainSubject;
use App\Model\ExtraPayModel;
use App\Model\ExtraPayUniversalModel;
use App\Model\MonthSetHollidayModel;
use App\Model\MonthSetModel;

class MonthSetPresenter extends BasePresenter
{
	/**
	 * @var IMonthSetFormFactory
	 * @inject
	 */
	public $montSetFormFactory;

	/**
	 * @var IExtraPayFormFactory
	 * @inject
	 */
	public $extraPayFormFactory;

	/**
	 * @var IMonthSetNoteFormFactory
	 * @inject
	 */
	public $monthSetNoteFormFactory;

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
	public $extraPaysModel;

	/**
	 * @var ExtraPayUniversalModel
	 * @inject
	 */
	public $extraPayUniversalModel;

	/**
	 * @var ClientUserModel
	 * @inject
	 */
	public $clientUserModel;

	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Mesiční sety', 'MonthSet:default');
	}

	/**
	 * @return \App\Component\Accounter\Form\MonthSetFormControl
	 */
	public function createComponentMonthSetForm()
	{
		return $this->montSetFormFactory->create();
	}

	/**
	 * @return \App\Component\Accounter\Form\ExtraPayFormControl
	 */
	public function createComponentExtraPayForm()
	{
		return $this->extraPayFormFactory->create();
	}

	public function createComponentMonthSetNoteForm()
	{
		return $this->monthSetNoteFormFactory->create();
	}

	/**
	 * @param null $year
	 * @throws \Doctrine\ORM\ORMException
	 */
	public function actionDefault( $year = null )
	{
		$this->template->years = $this->monthSetModel->getYears((int)$this->main_subject_id);
		$this->template->current_year = $year;
		$this->template->main_subject = new MainSubject($this->main_subject_id);


		$this->template->main_subject_id = (int)$this->main_subject_id;
		$this->template->sets = $this->monthSetModel->getListByMainSubject((int)$this->main_subject_id);
	}

	/**
	 * @param $main_subject_id integer
	 */
	public function actionAddMonthSet()
	{
		$this['monthSetForm']->setMainSubjectId((int)$this->main_subject_id);
	}

	public function actionEditMonthSet($month_set_id)
	{
		$this['monthSetForm']->setId((int)$month_set_id);
		$this['monthSetHollidayForm']->setMonthSetId((int)$month_set_id);

		$this->template->month_set = $this->monthSetModel->find($month_set_id);
		$this->template->hollidays = $this->template->month_set->getHollidays();
	}

	public function handleDeleteMonthSet( $id )
	{
		$month_set = $this->monthSetModel->find((int)$id);
		if( !$month_set ){
			$this->flashMessage('Set nebyl nalezen', 'danger');
		}
		else {
			$this->monthSetModel->delete($month_set);
			$this->flashMessage('Měsíc smazán '.$month_set->month->format('m. Y'), 'danger');
		}

		$this->redirect('default');
	}

	public function handleDeleteHolliday( $id )
	{
		$holliday = $this->monthSetHollidayModel->find((int)$id);
		$this->monthSetHollidayModel->delete( $holliday );
		$this->flashMessage('Smazáno', 'info');
		$this->redirect('this');
	}

	/**
	 * @param $id
	 * @throws \Nette\Application\AbortException
	 */
	public function handleDeleteExtraPay( $id )
	{
		$extraPay = $this->extraPaysModel->find((int)$id);
		$this->extraPaysModel->delete( $extraPay );
		$this->flashMessage('Smazáno', 'info');
		$this->redirect('this');
	}

	/**
	 * @param $id
	 * @throws \Doctrine\ORM\ORMException
	 */
	public function actionLockMonthSet( $id )
	{
		$monthSet = $this->monthSetModel->find((int)$id);
		$this['monthSetNoteForm']->setMonthSetId((int)$id);
		$this->template->MonthSet = $monthSet;
		$this->template->MainSubjectExtraPayType = $monthSet->getMain_subject()->main_subject_extra_pay_type;

		$extra_pays = [];

		foreach ( $this->template->MainSubjectExtraPayType->ept as $ept  ) {
			$extra_pays[$ept->id] = $this->extraPaysModel->getListByMsetExtraPayType((int)$id, $ept->id);
		}

		$this->template->extra_pays = $extra_pays;
		$this->template->extra_pays_universal = $monthSet->extra_pays_universal;

		$this->addBreadcrumb('Přehled měsíční sady', 'this');
	}

	public function handleLockMonthSet( $id )
	{
		$MonthSet = $this->monthSetModel->find((int)$id);
		$this->monthSetModel->lockMonthSet($MonthSet);
		$this->flashMessage( 'Sada uzamčena, nebude již možné dále sadu upravovat');
		$this->redirect('MonthSet:default');
	}

	public function actionMonthSetExtraPays($id)
	{
		$mont_set = $this->monthSetModel->find( (int)$id );
		$this->template->month_set = $mont_set;
		$this->template->extra_pays = $mont_set->getExtra_pays();
		$this['extraPayForm']->setMonthSetId( (int)$id );

	}

	public function actionSetNote( $id )
	{
		$this['monthSetNoteForm']->setMonthSetId((int)$id);
	}
}