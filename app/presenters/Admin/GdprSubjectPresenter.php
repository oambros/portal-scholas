<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 21:04
 */

namespace App\AdminModule\Presenters;


use App\Component\Gdpr\Form\IGdprSubjectFormFactory;
use App\Component\Gdpr\Form\IGdprSubjectTypeFormFactory;
use App\Model\GdprSubjectModel;
use App\Model\GdprSubjectTypeModel;

class GdprSubjectPresenter extends BasePresenter
{
	/**
	 * @var IGdprSubjectFormFactory
	 * @inject
	 */
	public $gdprSubjectFormFactory;

	/**
	 * @var GdprSubjectModel
	 * @inject
	 */
	public $gdprSubjectModel;

	/**
	 * @return \App\Component\Gdpr\Form\GdprSubjectTypeFormControl
	 */
	public function createComponentGdprSubjectForm()
	{
		return $this->gdprSubjectFormFactory->create();
	}

	public function actionDefault()
	{
		$this->template->subjects = $this->gdprSubjectModel->getList();
	}

	public function actionAddSubject()
	{

	}

	/**
	 * @param $id
	 */
	public function actionEditSubject( $id )
	{
		$this['gdprSubjectForm']->setId( (int)$id );
	}

	/**
	 * @param $id
	 * @throws \Nette\Application\AbortException
	 */
	public function handleDeleteSubject( $id )
	{
		$subject = $this->gdprSubjectModel->find((int)$id);
		$this->gdprSubjectModel->delete($subject);
		$this->redirect('this');
	}
}