<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 14.02.2019
 * Time: 11:16
 */

namespace App\AdminModule\Presenters;


use App\Model\Entity\MainSubject;
use App\Model\FinancingModel;
use App\Model\MainSubjectModel;
use App\Model\MonthSetModel;

abstract class BaseFinancing extends BasePresenter
{
	/**
	 * @var MonthSetModel
	 * @inject
	 */
	public $monthSetModel;

	/**
	 * @var MainSubjectModel
	 * @inject
	 */
	public $mainSubjectModel;

	/**
	 * @var FinancingModel
	 * @inject
	 */
	public $financingModel;

	/**
	 * @var MainSubject
	 */
	protected $main_sunject = null;

	/**
	 * BaseFinancing constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Seznam subjektů', 'MainSubject:default');
	}

	public function actionDefault($main_subject_id)
	{
		$this->main_sunject = $this->mainSubjectModel->find( (int)$main_subject_id );

		$this->addBreadcrumb('Financování '.$this->main_sunject->getName(), 'Financing:default', $this->main_sunject->getId() );

		if (!$this->main_sunject) {
			$this->errorFlash('Není zadáno id subjektu!');
			$this->redirect('MainSubject:default');
		}

		$this->template->main_subject = $this->main_sunject;
		$this->template->financings = $this->main_sunject->getFinancings();
	}

	public function handleDelete( $id )
	{
		$financing = $this->financingModel->find((int)$id);

		if( !$financing ) {
			$this->errorFlash('Financování nenalezeno');
		}
		else {
			$this->financingModel->delete( $financing );
			$this->infoFlash( 'Smazáno' );
		}
		$this->redirect('this');
	}
}