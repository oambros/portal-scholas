<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;

use App\Model\Entity\ExtraPayType;
use App\Model\ExtraPayTypeModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\DateTime;


class ExtraPayTypeFormControl extends Control
{

	protected $icon_classes = array(
		'fa-adjust' => 'fa-adjust',
		'fa-ban' => 'fa-ban',
		'fa-bolt' => 'fa-bolt',
		'fa-book' => 'fa-book',
		'fa-bookmark' => 'fa-bookmark',
		'fa-briefcase' => 'fa-briefcase',
		'fa-envelope' => 'fa-envelope',
		'fa-exclamation-circle' => 'fa-exclamation-circle',
		'fa-cutlery' => 'fa-cutlery',
		'fa-glass' => 'fa-glass',
		'fa-gavel' => 'fa-gavel',
		'fa-laptop' => 'fa-laptop',

	);

	protected $icon_colors = array(
		'grey' => 'grey',
		'red' => 'red',
		'blue' => 'blue',
		'green' => 'green',
		'purple' => 'purple',
		'info' => 'info',
		'pink' => 'pink',
		'yellow' => 'yellow'
	);

	/**
	 * @var integer
	 */
	protected $id = null;

	/**
	 * @var ExtraPayTypeModel
	 */
	protected $extraPayTypeModel;

	public $onExtraPayTypeSave;

	public function __construct(ExtraPayTypeModel $extraPayTypeModel)
	{
		$this->extraPayTypeModel = $extraPayTypeModel;
	}

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form
			->addText('name', 'Jméno typu')
			->addRule(Form::FILLED, 'Musíte zadat název typy');

		$form
			->addText('form_type', 'Typ formuláře (např. f50)')
			->addRule(Form::FILLED, 'Musíte vyplnit typ formuláře');

		$form
			->addSelect('base_type', 'Typ příplatku', array(1 => 'Hodinový', 2 => 'Částkou', 3 => 'Částka i hodiny'));

		$form
			->addTextArea('note', 'Popis příplatku');

		$form
			->addText('odmdr', 'Numerická hodnota příplatku (odmdr)')
			->addRule(Form::NUMERIC, 'Musí být číslem!');

		$form
			->addRadioList('icon_class', 'Ikonka', $this->icon_classes);
		$form
			->addRadioList('icon_color', 'Barva ikony', $this->icon_colors);

		$form
			->addCheckbox('active', 'Aktivní');

		if( $this->id ) {
			$form->setDefaults($this->extraPayTypeModel->find((int)$this->id, true));
		}

		$form
			->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'formSubmit');

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit(Form $form)
	{
		$data = $form->getValues(false);

		if( $this->id ) {
			$entity = $this->extraPayTypeModel->find(($this->id));
			$entity->setUpdate_date( new DateTime('now') );
		}
		else {
			$entity = new ExtraPayType();
		}

		$entity->setName( $data->name );
		$entity->setBase_type( $data->base_type );
		$entity->setNote( $data->note );
		$entity->setOdmdr( $data->odmdr);
		$entity->setForm_type( $data->form_type);
		$entity->setIcon_class($data->icon_class);
		$entity->setIcon_color($data->icon_color);
		$entity->setActive( $data->active );

		$this->extraPayTypeModel->save($entity);

		$this->onExtraPayTypeSave($this, $entity);

	}

	public function render()
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}