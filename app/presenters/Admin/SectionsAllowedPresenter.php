<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 24.10.2018
 * Time: 15:10
 */

namespace App\AdminModule\Presenters;



use App\Component\Section\Forms\ISectionFormFactory;
use App\Model\SectionAllowedModel;

class SectionsAllowedPresenter extends BasePresenter
{
	/**
	 * @var SectionAllowedModel
	 * @inject
	 */
	public $sectionAllowedModel;

	/**
	 * @var ISectionFormFactory
	 * @inject
	 */
	public $sectionFormFactory;


	public function createComponentSectionForm()
	{
		return $this->sectionFormFactory->create();
	}

	public function actionAddSection()
	{

	}

	public function actionEditSection( $id )
	{
		$section = $this->sectionAllowedModel->find($id);

		if(!$section) {
			$this->flashMessage('Sekce nenalezena', 'error');
			$this->redirect('default');
		}
		else
			$this['sectionForm']->setId($id);
	}


	public function actionDefault()
	{
		$this->template->sections = $this->sectionAllowedModel->getList();
	}
}