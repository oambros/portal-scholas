<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 04.02.2018
 * Time: 0:53
 */

namespace App\Component\Gdpr\Form;


use App\Model\Entity\GdprOouType;
use App\Model\GdprOouTypeModel;
use App\Model\GdprSubjectModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class GdprOouTypeFormControl extends Control
{

	protected $id = false;

	/**
	 * @var int
	 */
	protected $position_min = -10;

	/**
	 * @var int
	 */
	protected $position_max = 20;

	/**
	 * @var GdprSubjectModel
	 */
	protected $gdprSubjectModel;

	/**
	 * @var GdprOouTypeModel
	 */
	protected $gdprOouTypeModel;

	/**
	 * GdprOouTypeFormControl constructor.
	 * @param GdprSubjectModel $gdprSubjectModel
	 * @param GdprOouTypeModel $gdprOouTypeModel
	 */
	public function __construct( GdprSubjectModel $gdprSubjectModel, GdprOouTypeModel $gdprOouTypeModel )
	{
		$this->gdprSubjectModel = $gdprSubjectModel;
		$this->gdprOouTypeModel = $gdprOouTypeModel;
	}

	/**
	 * @param $id
	 */
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
			->addText('name', 'Název typu údaje')
			->addRule(Form::FILLED, 'Je nutné zadat název');

		$form
			->addTextArea('note', 'Poznámka');
		$form
			->addSelect('position', 'Pozice', $this->getPositionsValues());

		$form
			->addSubmit('save', 'Uložit');

		$form
			->onSubmit[] = array($this, 'formSubmit');

		if( $this->id )
			$form
				->setDefaults($this->gdprOouTypeModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues();

		if($this->id) {
			$oou_type = $this->gdprOouTypeModel->find($this->id);
		}
		else {
			$oou_type = new GdprOouType();
		}

		$oou_type->setName($data->name);
		$oou_type->setNote($data->note);
		$oou_type->setPosition($data->position);

		$this->gdprOouTypeModel->save($oou_type);
		$this->presenter->redirect('default');
	}

	/**
	 * @param int $min
	 * @param int $max
	 */
	public function setPositionValues( $min = -10, $max = 20 )
	{
		$this->position_min = ($min != null ? $min : $this->min);
		$this->position_max = ($max != null ? $min : $this->max);
	}

	/**
	 * @return array
	 */
	protected function getPositionsValues() {
		$array = array();
		for ( $i = $this->position_min; $i <= $this->position_max; $i++) {
			$array[] = $i;
		}
		return $array;
	}

	public function render()
	{
		$tempalte = $this->createTemplate();
		$tempalte->setFile(__DIR__ . '/form.latte');
		$tempalte->render();
	}
}