<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;


use App\Model\ClientTypeModel;
use App\Model\Entity\ClientType;
use App\Model\Entity\MainSubject;
use App\Model\ExtraPayTypeModel;
use App\Model\MainSubjectExtraPayTypeModel;
use App\Model\MainSubjectModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class MainSubjectFormControl extends Control
{
	/**
	 * @var MainSubjectModel
	 */
	protected $mainSubjectModel;

	/**
	 * @var MainSubjectExtraPayTypeModel
	 */
	protected $mainSubjectExtraPayTypeModel;

	/**
	 * @var integer
	 */
	protected $id = false;


	public function __construct(MainSubjectModel $mainSubjectModel, MainSubjectExtraPayTypeModel $mainSubjectExtraPayTypeModel)
	{
		$this->mainSubjectModel= $mainSubjectModel;
		$this->mainSubjectExtraPayTypeModel = $mainSubjectExtraPayTypeModel;
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
			->addText('name', 'Název')
			->addRule(Form::FILLED, 'Musíte zadat název');

		$form
			->addText('v_id', 'Vema id');
		$form
			->addText('street', 'Ulice');

		$form
			->addText('cp', 'Číslo popisné');

		$form
			->addText('town', 'Město');

		$form
			->addText('zip', 'Zip');

		$form
			->addText('ico', 'Ičo');

		$form
			->addText('dic', 'dič');

		$form
			->addTextArea('note', 'Popis');

		$form
			->addSelect('main_subject_extra_pay_type', 'Typ subjektu', $this->mainSubjectExtraPayTypeModel->getCheckboxList());

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');

		if( $this->id )
			$form->setDefaults($this->mainSubjectModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		if($this->id) {
			$entity = $this->mainSubjectModel->find($this->id);
		}
		else {
			$entity = new MainSubject();
		}

		$entity->setName( $data->name );
		$entity->setV_id( $data->v_id );
		$entity->setNote( $data->note );
		$entity->setStreet( $data->street );
		$entity->setCp( $data->cp );
		$entity->setTown( $data->town );
		$entity->setZip( $data->zip );
		$entity->setIco( $data->ico );
		$entity->setDic( $data->dic );
		$entity->setMain_subject_extra_pay_type($this->mainSubjectExtraPayTypeModel->find($data->main_subject_extra_pay_type));

		if( $this->mainSubjectModel->save($entity) ) {
			$this->presenter->flashMessage('Uloženo');
			$this->presenter->redirect('MainSubject:default');
		}

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}