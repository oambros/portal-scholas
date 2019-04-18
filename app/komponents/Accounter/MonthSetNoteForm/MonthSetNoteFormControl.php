<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;

use App\Model\MonthSetModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class MonthSetNoteFormControl extends Control
{
	/**
	 * @var integer
	 */
	protected $month_set_id = null;

	protected $monthSetModel;

	public function __construct( MonthSetModel $monthSetModel )
	{
		$this->monthSetModel = $monthSetModel;
	}

	/**
	 * @param $id
	 */
	public function setMonthSetId($id)
	{
		$this-> month_set_id = (int)$id;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form->addHidden('month_set_id')
			->setDefaultValue($this->month_set_id);

		$form->addTextArea('note', 'Poznámka k sadě:')
			->setHtmlAttribute('class', 'form-control limited col-xs-12')
			->setHtmlAttribute('placeholder', 'Pokud chcete, vložte poznámku s sadě dat')
			->setDefaultValue($this->monthSetModel->find((int)$this->month_set_id)->note);

		$form
			->addSubmit('submit', 'Ulož poznámku')
			->setHtmlAttribute('class', 'btn btn-purple');

		$form->onSuccess[] = array($this, 'formSubmit');


		return $form;
	}

	/**
	 * @param Form $form
	 * @throws \Nette\Application\AbortException
	 */
	public function formSubmit(Form $form)
	{
		$data = $form->getValues(false);

		$entity = $this->monthSetModel->find((int)$data->month_set_id);
		$entity->setNote( $data->note );

		$this->monthSetModel->save($entity);

		$this->presenter->flashMessage('Poznámka uložena');

		$this->presenter->redirect('this');


	}

	public function render()
	{
		$template = $this->createTemplate();

		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}