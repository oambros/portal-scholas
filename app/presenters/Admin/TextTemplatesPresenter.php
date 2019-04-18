<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 19:20
 */

namespace App\AdminModule\Presenters;


use App\Model\TextTemplatesModel;

class TextTemplatesPresenter extends BasePresenter
{

	/**
	 * @var TextTemplatesModel
	 * @inject
	 */
	public $textTeplateModel;

	public function actionDefault() {
		$this->template->teplates = $this->textTeplateModel->getList();
	}

	public function handleDeleteTemplate($id) {
		$template = $this->textTeplateModel->find($id);
		$this->textTeplateModel->delete($template);
		$this->flashMessage('Předloha smazána');
		$this->redirect('this');
	}
}