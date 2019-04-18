<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:34
 */

namespace App\AdminModule\Presenters;

use App\Component\Gdpr\Form\IGdprSubjectTypeFormFactory;
use App\Model\GdprSubjectTypeModel;

class GdprSubjectTypePresenter extends BasePresenter
{
	/**
	 * @var GdprSubjectTypeModel
	 * @inject
	 */
	public $gdprSubjectTypeModel;

	/**
	 * @var IGdprSubjectTypeFormFactory
	 * @inject
	 */
	public $gdprSubjectTypeFormFactory;

	/**
	 * @return \App\Component\Gdpr\Form\GdprSubjectTypeFormControl
	 */
	public function createComponentEditForm()
	{
		return $this->gdprSubjectTypeFormFactory->create();
	}

	public function actionDefault()
	{
		$this->template->subject_types = $this->gdprSubjectTypeModel->getList();
	}

	public function actionAddSubjectType()
	{

	}

	/**
	 * @param $id integer
	 */
	public function actionEditSubjectType($id)
	{
		$this['editForm']->setId((int)$id);
	}

	/**
	 * @param $id integer
	 * @throws \Nette\Application\AbortException
	 */
	public function handleDeleteType( $id )
	{
		$type = $this->gdprSubjectTypeModel->find((int)$id);
		if( count($type->getGdpr_subjects()) ) {
			$this->flashMessage('Nelze smazat, tento typ je asociován u několika subjektů', 'danger');
		}
		else {
			$this->gdprSubjectTypeModel->delete( $type );
		}

		$this->redirect('this');
	}

}