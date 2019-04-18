<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 28.12.2018
 * Time: 19:51
 */

namespace App\AdminModule\Presenters;

use App\Component\Accounter\Form\ExtraPayTypeFormControl;
use App\Component\Accounter\Form\IExtraPayTypeFormFactory;
use App\Model\ExtraPayTypeModel;

class ExtraPayTypePresenter extends BasePresenter
{
	/**
	 * @var ExtraPayTypeModel
	 * @inject
	 */
	public $extraPayTypeModel;

	/**
	 * @var IExtraPayTypeFormFactory
	 * @inject
	 */
	public $extraPayTypeFormFactory;

	/**
	 * @return \App\Component\Accounter\Form\ExtraPayTypeFormControl
	 */
	public function createComponentForm()
	{
		$control = $this->extraPayTypeFormFactory->create();
		$control->onExtraPayTypeSave[] = function (ExtraPayTypeFormControl $control, $ExtraPayType)
		{
			$this->infoFlash('Typ uložen');
			$this->redirect('ExtraPayType:default');
		};
		return $control;
	}

	public function actionDefault()
	{
		$this->template->ExtraPayTypes = $this->extraPayTypeModel->getList();
	}

	public function actionAdd()
	{

	}

	public function actionEdit($id)
	{
		$this['form']->setId((int)$id);
	}

	/**
	 * @param $id
	 * @throws \Nette\Application\AbortException
	 */
	public function handleDelete( $id )
	{
		$entity = $this->extraPayTypeModel->find((int)$id);
		if( !$entity )
			$this->errorFlash('Typ nenalezen!');
		else {
			if( count($entity->extra_pays) > 0 ) {
				$this->errorFlash('Nelze smazat, typ je použit');
			}
			else {
				$this->extraPayTypeModel->delete($entity);
				$this->infoFlash('Typ smazán');
			}
		}

		$this->redirect('this');
	}

}