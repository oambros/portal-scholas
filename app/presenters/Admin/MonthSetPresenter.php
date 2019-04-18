<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:15
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\IExtraPayFormFactory;
use App\Component\Accounter\Form\IMonthSetFormFactory;
use App\Component\Accounter\Form\IMonthSetHollidayFormFactory;
use App\Component\Accounter\Form\IMonthSetNoteFormFactory;
use App\Model\Entity\MonthSet;
use Nette\Application\Responses\JsonResponse;
use OHWeb\Application\Responses\CsvResponse;

final class MonthSetPresenter extends BaseMonthSet
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
	 * @var IMonthSetHollidayFormFactory
	 * @inject
	 */
	public $monthSetHollidayFormFactory;

	/**
	 * @var IMonthSetNoteFormFactory
	 * @inject
	 */
	public $monthSetNoteFormFactory;


	/**
	 * @return \App\Component\Accounter\Form\MonthSetFormControl
	 */
	public function createComponentMonthSetForm()
	{
		return $this->montSetFormFactory->create();
	}

	/**
	 * @return \App\Component\Accounter\Form\MonthSetHollidayFormControl
	 */
	public function createComponentMonthSetHollidayForm()
	{
		return $this->monthSetHollidayFormFactory->create();
	}

	/**
	 * @return \App\Component\Accounter\Form\ExtraPayFormControl
	 */
	public function createComponentExtraPayForm()
	{
		return $this->extraPayFormFactory->create();
	}

	/**
	 * @return \App\Component\Accounter\Form\MonthSetNoteFormControl
	 */
	public function createComponentMonthSetNoteForm()
	{
		return $this->monthSetNoteFormFactory->create();
	}

	/**
	 * @param $id
	 * @param null $year
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Nette\Application\AbortException
	 */
	public function actionDefault( $id, $year = null )
	{
		$this->template->years = $this->monthSetModel->getYears($id);
		$this->template->current_year = $year;

		if( !$id ) {
			$this->errorFlash('Nebylo zadáno id subjektu!');
			$this->redirect('MainSubject:default');
		}

		$this->template->main_subject_id = (int)$id;
		$this->template->main_subject = $this->mainSubjectModel->find((int)$id);
		$this->addBreadcrumb( $this->template->main_subject->getName() );
		$this->template->sets = $this->monthSetModel->getListByMainSubject($id, $year);

	}

	/**
	 * @param $id
	 * @throws \Doctrine\ORM\ORMException
	 */
	public function actionAddMonthSet($id)
	{
		parent::actionAddMonthSet( $id );
		$this->addBreadcrumb('Měsíční sety '.$this->main_subject->getName(), 'MonthSet:default', $id);
		$this->addBreadcrumb('Přidej měsíční set');
		$this['monthSetForm']->setMainSubjectId((int)$id);
		$this->template->sets = $this->monthSetModel->getListByMainSubject((int)$id);
	}

	public function actionEditMonthSet($month_set_id)
	{
		$this['monthSetForm']->setId((int)$month_set_id);
		$this['monthSetHollidayForm']->setMonthSetId((int)$month_set_id);

		$this->template->month_set = $this->monthSetModel->find($month_set_id);

		$this->template->hollidays = $this->template->month_set->getHollidays();
	}

	public function actionMonthSetExtraPays($id)
	{

		$mont_set = $this->monthSetModel->find( (int)$id );
		$this->template->month_set = $mont_set;
		$this->template->extra_pays = $mont_set->getExtra_pays();
		$this['extraPayForm']->setMonthSetId( (int)$id );

	}

	public function handleDeleteMonthSet( $id )
	{
		$month_set = $this->monthSetModel->find((int)$id);
		if( !$month_set ){
			$this->flashMessage('Set nebyl nalezen', 'danget');

		}
		else {
			$main_subject_id = $month_set->getMain_subject()->getId();

			$this->monthSetModel->delete($month_set);
			$this->flashMessage('Měsíc smazán '.$month_set->month->format('m. Y'), 'danger');
		}
		$this->redirect('default', $main_subject_id);
	}

	public function handleDeleteExtraPay( $id )
	{
		$extraPay = $this->extraPayModel->find((int)$id);
		$this->extraPayModel->delete( $extraPay );
		$this->flashMessage('Smazáno', 'info');
		$this->redirect('this');
	}



	public function handleSwitchLock( $month_set_id )
	{
		$this->monthSetModel->switchLocked( (int)$month_set_id, $this->user->getIdentity()->f_name.' '.$this->user->getIdentity()->l_name );

		$this->flashMessage('Upraveno');
		$this->redirect('this');
	}

	public function handleCreateHollidayCsv( $id )
	{

		$month_set = $this->monthSetModel->find((int)$id);
		$this->array_to_csv_download( $month_set );
	}

	protected function array_to_csv_download( MonthSet $monthSet ) {
		$header = array("*f50[,;'0],;oscis","cicin","prijm","pracv","zapl","odmdr","odmph","odmcas","odmp","odmnj","odmin","odmpr","odmcin","odmzak","odmmo","odmpm","odmdo","odmrf","idproc","doplud;");
		
		$list = array
		(
			$header,
			$header
		);

		$filename = $monthSet->getMain_subject()->name.time();

		$response = new CsvResponse($list, $filename.".csv");
		$this->sendResponse($response);

	}

	public function handleGetExtraPayNote( )
	{
		$pay_id = $this->getHttpRequest()->getQuery('id');
		$extra_pay = $this->extraPayModel->find((int)$pay_id);
		if( !$extra_pay ) {
			$response_array = array('error' => true, 'error_message' => 'Poznámka nenalezena');
		}
		else
			$response_array = array('error' => false, 'error_message' => 'Ok', 'Note' =>  $extra_pay->getNote());

		$response = new JsonResponse( $response_array );
		$this->sendResponse( $response );
	}
}