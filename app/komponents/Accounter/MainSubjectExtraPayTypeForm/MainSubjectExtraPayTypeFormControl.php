<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;


use App\Model\Entity\MainSubjectExtraPayType;
use App\Model\ExtraPayTypeModel;
use App\Model\MainSubjectExtraPayTypeModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\DateTime;


class MainSubjectExtraPayTypeFormControl extends Control
{

	/**
	 * @var integer
	 */
	protected $id = null;

	/**
	 * @var MainSubjectExtraPayTypeModel
	 */
	protected $mainSubjectExtraPayModel;

	/**
	 * @var ExtraPayTypeModel
	 */
	protected $extraPayTypeModel;

	public $onMainSubjectExtraPayTypeSave;

	/**
	 * MainSubjectExtraPayTypeFormControl constructor.
	 * @param MainSubjectExtraPayTypeModel $mainSubjectExtraPayTypeModel
	 * @param ExtraPayTypeModel $extraPayTypeModel
	 */
	public function __construct(MainSubjectExtraPayTypeModel $mainSubjectExtraPayTypeModel, ExtraPayTypeModel $extraPayTypeModel)
	{
		$this->mainSubjectExtraPayModel = $mainSubjectExtraPayTypeModel;
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
			->addText('name', 'Jméno sady typů')
			->addRule(Form::FILLED, 'Musíte zadat název sady');

		$form
			->addTextArea('note', 'Popis sady příplatků');

		$form
			->addCheckboxList('ept', 'Typy příplatků', $this->extraPayTypeModel->getCheckboxList());

		if( $this->id ) {
			$form->setDefaults($this->mainSubjectExtraPayModel->find((int)$this->id, true));
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
			$entity = $this->mainSubjectExtraPayModel->find($this->id);
			$entity->setUpdate_date( new DateTime('now') );
		}
		else {
			$entity = new MainSubjectExtraPayType();
		}

		$entity->setName( $data->name );
		$entity->setNote( $data->note );

		$entity->clearEpt();

		foreach ($data->ept as $type) {
			$entity->addEpt($this->extraPayTypeModel->find((int)$type));
		}

		$this->mainSubjectExtraPayModel->save($entity);

		$this->onMainSubjectExtraPayTypeSave($this, $entity);
	}

	public function render()
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}