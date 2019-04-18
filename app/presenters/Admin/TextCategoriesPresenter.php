<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 13:36
 */

namespace App\AdminModule\Presenters;

use App\Component\Texts\Form\ITextCategoryFormFactory;
use App\Model\TextCategoriesModel;

class TextCategoriesPresenter extends BasePresenter
{
	/**
	 * @var ITextCategoryFormFactory
	 * @inject
	 */
	public $textCategoryFormFactory;

	/**
	 * @var TextCategoriesModel
	 * @inject
	 */
	public $textCategoryModel;

	public function createComponentCategoryForm()
	{
		return $this->textCategoryFormFactory->create();
	}

	public function actionDefault()
	{
		$this->template->textCategories = $this->textCategoryModel->getList();
	}

	public function actionAddTextCategory()
	{

	}

	public function actionEditTextCategory( $id )
	{
		$this['categoryForm']->setId( (int)$id );
	}

	public function handleDeleteTextCategory( $id )
	{
		$textCategory = $this->textCategoryModel->find($id);
		if($textCategory) {
			$this->textCategoryModel->delete($textCategory);
			$this->flashMessage('Smazáno');
		}
		else {
			$this->flashMessage('Smazání se nepodařilo');
		}
		$this->redirect('TextCategories:default');
	}
}