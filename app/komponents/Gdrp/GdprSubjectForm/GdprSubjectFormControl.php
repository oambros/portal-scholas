<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 03.02.2018
 * Time: 22:19
 */

namespace App\Component\Gdpr\Form;


use App\Model\Entity\GdprSubjectEntity;
use App\Model\Entity\GdprSubjectType;
use App\Model\GdprOouTypeModel;
use App\Model\GdprSubjectModel;
use App\Model\GdprSubjectTypeModel;
use App\Model\GdprTeamsModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class GdprSubjectFormControl extends Control
{

	protected $id = false;

	/**
	 * @var GdprSubjectModel
	 */
	protected $gdprSubjectModel;

	/**
	 * @var GdprSubjectTypeModel
	 */
	protected $gdprSobjectTypeModel;

	/**
	 * @var GdprOouTypeModel
	 */
	protected $gdprOouTypeModel;

	/**
	 * @var GdprTeamsModel
	 */
	protected $gdprTeamsModel;
	/**
	 * GdprSubjectFormControl constructor.
	 * @param GdprSubjectModel $gdprSubjectModel
	 * @param GdprSubjectTypeModel $gdprSubjectTypeModel
	 * @param GdprTeamsModel $gdprTeamsModel
	 */
	public function __construct(
		GdprSubjectModel $gdprSubjectModel,
		GdprSubjectTypeModel $gdprSubjectTypeModel,
		GdprOouTypeModel $gdprOouTypeModel,
		GdprTeamsModel $gdprTeamsModel
	)
	{
		$this->gdprSubjectModel = $gdprSubjectModel;
		$this->gdprSobjectTypeModel = $gdprSubjectTypeModel;
		$this->gdprOouTypeModel = $gdprOouTypeModel;
		$this->gdprTeamsModel = $gdprTeamsModel;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form
			->addText('name', 'Název subjektu')
			->addRule(Form::FILLED, 'Musíte vyplnit Název subjektu');

		$form
			->addTextArea('note', 'Popis');

		$form
			->addText('street', 'Ulice');

		$form
			->addText('cp', 'Číslo popisné');

		$form
			->addText('city', 'Město');

		$form
			->addText('zip', 'PSČ');

		$form
			->addText('lat', 'Lat');

		$form
			->addText('lng', 'Lng');

		$form
			->addCheckbox('sign', 'Podepsáno');

		$form
			->addText('sheet_id', 'Id goodle sheet');

		$form
			->addText('prioriry', 'Proirita')
			->addRule(Form::NUMERIC, 'Pouze číslo');

		$form
			->addSelect('gdpr_subject_type', 'Typ subjektu', $this->gdprSobjectTypeModel->getSelectList());

		/*$form
			->addCheckboxList('gdpr_oou_types', 'Typy osobních údajů', $this->gdprOouTypeModel->getCheckboxList());*/

		$form
			->addSelect('team', 'Team', $this->gdprTeamsModel->getSelectList());

		$form->addSubmit('save', 'Ulož');

		$form
			->onSubmit[] = array($this, 'formSubmit');

		if ($this->id)
			$form->setDefaults($this->gdprSubjectModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit(Form $form)
	{
		$data = $form->getValues();

		if ($this->id) {
			$subject = $this->gdprSubjectModel->find($this->id);
		} else {
			$subject = new GdprSubjectEntity();
		}

		$subject->setName($data->name);
		$subject->setNote($data->note);
		$subject->setStreet($data->street);
		$subject->setCp($data->cp);
		$subject->setCity($data->city);
		$subject->setZip($data->zip);
		$subject->setLat($data->lat);
		$subject->setLng($data->lng);
		$subject->setSign($data->sign);
		$subject->setPriority($data->prioriry);

		$subject->setTeam($this->gdprTeamsModel->find($data->team));

		$subject->setGdpr_subject_type($this->gdprSobjectTypeModel->find($data->gdpr_subject_type));

		$this->gdprSubjectModel->save($subject);

	}



	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}