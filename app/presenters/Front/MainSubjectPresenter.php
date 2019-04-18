<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.10.2018
 * Time: 11:17
 */

namespace App\FrontModule\Presenters;


use App\Component\Accounter\Form\IMainSubjectFormFactory;
use App\Model\MainSubjectModel;

class MainSubjectPresenter extends BasePresenter
{
	/**
	 * @var MainSubjectModel
	 * @inject
	 */
	public $mainSubjectModel;

	/**
	 * @var IMainSubjectFormFactory
	 * @inject
	 */
	public $mainSubjectFormFactory;

	/**
	 * @return \App\Component\Accounter\Form\MainSubjectFormControl
	 */
	public function createComponentMainSubjectForm()
	{
		return $this->mainSubjectFormFactory->create();
	}
 
	public function actionAddMainSubject( )
	{

	}

	public function actionEditMainSubject($id)
	{
		$this['mainSubjectForm']->setId((int)$id);
	}

	
	public function actionDefault()
	{
		$this->template->main_subjects = $this->mainSubjectModel->getList();
	}

}