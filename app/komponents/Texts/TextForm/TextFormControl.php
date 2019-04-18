<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 14:44
 */

namespace App\Component\Texts\Form;


use App\Model\Entity\Texts;
use App\Model\TextCategoriesModel;
use App\Model\TextsModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class TextFormControl extends Control
{
	/**
	 * @var TextsModel
	 */
	protected $textsModel;

	/**
	 * @var TextCategoriesModel
	 */
	protected $textCategoriesModel;
	/**
	 * @var integer
	 */
	protected $id;

	/**
	 * TextFormControl constructor.
	 * @param TextsModel $textsModel
	 * @param TextCategoriesModel $textCategoriesModel
	 */
	public function __construct(TextsModel $textsModel, TextCategoriesModel $textCategoriesModel)
	{
		$this->textsModel = $textsModel;
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

		$form->addTextArea('text', 'Text:')
		->addRule(Form::FILLED, 'Zadejte text prosím');

		$form->addSelect('text_category', 'Kategorie', $this->textCategoriesModel->getSelectList());

		if( $this->id ) {
			$form->setDefaults($this->textsModel->find($this->id, true));
		}

		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'onSubmit');
		return $form;
	}

	public function onSubmit( Form $form )
	{
		$data = $form->getValues();
		if($this->id) {
			$text = $this->textsModel->find($this->id);
		}
		else {
			$text = new Texts();
		}

		$text->setText( $data->text );

		$text->setText_category($this->textCategoriesModel->find($data->text_category));

		if($this->textsModel->save( $text )) {
			$this->presenter->flashMessage('Upraveno');
		}

		$this->presenter->redirect('Texts:default');

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->render();
	}

}