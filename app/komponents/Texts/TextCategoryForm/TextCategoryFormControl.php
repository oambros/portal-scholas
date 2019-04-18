<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 13:39
 */

namespace App\Component\Texts\Form;

use App\Model\Entity\TextCategories;
use App\Model\TextCategoriesModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class TextCategoryFormControl extends Control
{
	/**
	 * @var TextCategoriesModel
	 */
	protected $textCategoriesModel;

	/**
	 * @var integer
	 */
	protected $id;

	public function __construct( TextCategoriesModel $textCategoriesModel )
	{
		$this->textCategoriesModel = $textCategoriesModel;
	}

	/**
	 * @param integer $id
	 */
	public function setId( $id )
	{
		$this->id = (int)$id;
	}

	public function createComponentForm()
	{
		$form = new Form();

		$form->addText('name', 'Jméno:')
		->addRule(Form::FILLED, 'Musíte zadat jméno kategorie');
		$form->addText('note', 'poznámka');

		if( $this->id ) {
			$form->setDefaults($this->textCategoriesModel->find($this->id, true));
		}

		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'onSubmit');
		return $form;
	}

	public function onSubmit( Form $form )
	{
		$data = $form->getValues();
		if($this->id) {
			$shop = $this->textCategoriesModel->find($this->id);
		}
		else {
			$shop = new TextCategories();
		}

		$shop->setName( $data->name );
		$shop->setNote( $data->note );


		if($this->textCategoriesModel->save( $shop )) {
			$this->presenter->flashMessage('Upraveno');
		}

		$this->presenter->redirect('TextCategories:default');

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->render();
	}
}