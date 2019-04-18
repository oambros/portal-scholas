<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 13:38
 */

namespace App\AdminModule\Presenters;


use App\Component\Texts\Form\ITextFormFactory;
use App\Model\TextsModel;

class TextsPresenter extends BasePresenter
{
	/**
	 * @var ITextFormFactory
	 * @inject
	 */
	public $textFormFactory;

	/**
	 * @var TextsModel
	 * @inject
	 */
	public $textsModel;

	/**
	 * @return \App\Component\Texts\Form\TextFormControl
	 */
	public function createComponentTextForm() {
		return $this->textFormFactory->create();
	}

	public function actionDefault()
	{
		$this->template->texts = $this->textsModel->getList();
	}

	public function actionAddText()
	{

	}

	public function actionEditText( $id )
	{
		$this['textForm']->setId($id);
	}

	public function handleDeleteText($id)
	{
		$text = $this->textsModel->find((int)$id);
		$this->textsModel->delete($text);
		$this->redirect('Texts:default');
	}
}