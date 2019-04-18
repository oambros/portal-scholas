<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 15:33
 */

namespace App\Component\Texts\Generator;


use App\Model\Entity\TextTemplate;
use App\Model\TextCategoriesModel;
use App\Model\TextsModel;
use App\Model\TextTemplatesModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class TextGeneratorControl extends Control
{
	/**
	 * @var TextsModel
	 */
	protected $textsModel;

	/**
	 * @var TextTemplatesModel
	 */
	protected $textTemplateModel;
	/**
	 * @var integer
	 */
	protected $id = null;
	/**
	 * @var TextCategoriesModel
	 */
	protected $textCategoriesModel;

	protected $category_filters = null;

	protected $text_filter = null;

	/**
	 * TextGeneratorControl constructor.
	 * @param TextsModel $textsModel
	 * @param TextTemplatesModel $textTemplateModel
	 * @param TextCategoriesModel $textCategoriesModel
	 */
	public function __construct(TextsModel $textsModel, TextTemplatesModel $textTemplateModel, TextCategoriesModel $textCategoriesModel)
	{
		$this->textsModel = $textsModel;
		$this->textTemplateModel = $textTemplateModel;
		$this->textCategoriesModel = $textCategoriesModel;
	}

	/**
	 * @param $id
	 */
	public function setId( $id )
	{
		$this->id = (int)$id;
	}

	public function handleSetFilters()
	{
		$this->category_filters = (int)$this->presenter->request->getPost('category_filter');

		$this->redrawControl('generator-table');
	}
	
	public function createComponentTemplateForm()
	{
		$form = new Form();

		$form
			->addText('name', 'Jméno šablony')
			->addRule(Form::FILLED, 'Šablona musí mít jméno!');;

		$form
			->addTextArea('text', null)
			->addRule(Form::FILLED, 'Musíte vyplnit alespoň nějaký text');


		$form->addSubmit('save', 'Ulož si mě :)');

		$form->onSuccess[] = array($this, 'templateFormSubmit');

		if($this->id) {
			$form->setDefaults($this->textTemplateModel->find($this->id, true));
		}

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function templateFormSubmit(Form $form)
	{
		$data = $form->getValues();

		if ($this->id) {
			$template = $this->textTemplateModel->find($this->id);
		} else {
			$template = new TextTemplate();
		}

		$template->setName($data->name);
		$template->setText($data->text);

		$this->textTemplateModel->save($template);

		$this->presenter->redirect('this', array('id' => $template->getId()));

		dump($template->getId());
	}
	
	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/template.latte');

		$template->id = $this->id;

		if ($this->category_filters) {
			$template->texts = $this->textsModel->getList(array('text_category' => $this->category_filters));
		} else {
			$template->texts = $this->textsModel->getList();
		}

		$template->category_filter = $this->category_filters;
		$template->text_categories = $this->textCategoriesModel->getList();

		$template->render();
	}
}