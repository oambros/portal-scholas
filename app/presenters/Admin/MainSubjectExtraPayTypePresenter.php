<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 28.12.2018
 * Time: 22:49
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\IMainSubjectExtraPayTypeFormFactory;
use App\Model\MainSubjectExtraPayTypeModel;

class MainSubjectExtraPayTypePresenter extends BasePresenter
{
	/**
	 * @var MainSubjectExtraPayTypeModel
	 * @inject
	 */
	public $mainSubjectExtraPayModel;

	/**
	 * @var IMainSubjectExtraPayTypeFormFactory
	 * @inject
	 */
	public $mainSubjectExtraPayFormFactory;

	public function createComponentForm()
	{
		$control = $this->mainSubjectExtraPayFormFactory->create();

		$control->onMainSubjectExtraPayTypeSave[] = function ($control, $mainSubjectExtraPayType) {
			$this->infoFlash('Uloženo');
			$this->redirect('MainSubjectExtraPayType:default');
		};

		return $control;
	}

	public function actionEdit( $id )
	{
		$this['form']->setId( (int)$id );
	}

	public function actionAdd()
	{

	}

	public function actionDefault()
	{
		$this->template->main_subject_extra_pay_types = $this->mainSubjectExtraPayModel->getList();
	}

	public function handleDelete($id) {
		$entity = $this->mainSubjectExtraPayModel->find((int)$id);
		$this->mainSubjectExtraPayModel->delete($entity);
		$this->infoFlash('Smazáno');
		$this->redirect('this');
	}
}