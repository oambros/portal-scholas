<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;

use App\Listeners\MonthSetListener;
use App\Model\Entity\MonthSet;
use App\Model\MainSubjectModel;
use App\Model\MonthSetModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class MonthSetFormControl extends Control
{
	/**
	 * @var MonthSetModel
	 */
	protected $MonthSetModel;

	/**
	 * @var MainSubjectModel
	 */
	protected $MainSubjectModel;

	/**
	 * @var integer
	 */
	protected $main_subject_id = false;

	/**
	 * @var integer
	 */
	protected $id = false;


	public function __construct( MonthSetModel $MonthSetModel, MainSubjectModel $mainSubjectModel)
	{
		$this->MonthSetModel= $MonthSetModel;
		$this->MainSubjectModel = $mainSubjectModel;

	}

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
	}

	/**
	 * @param $id
	 */
	public function setMainSubjectId($id)
	{
		$this->main_subject_id = (int)$id;
	}

	protected function monthSelectGenerate()
	{
		$aj = array("January","February","March","April","May","June","July","August","September","October","November","December");
		$cz = array("leden","únor","březen","duben","květen","červen","červenec","srpen","září","říjen","listopad","prosinec");

		$array = array();

		$year = date('Y', time());

		for ( $i = 1; $i <= 12; $i++ ) {
			$array[sprintf("%02d", $i).'/01/'.$year] = str_replace($aj, $cz, date('F Y', strtotime('1.'.$i.'.'.$year)));
		}

		return $array;
	}

	protected function getDisabled( $array ) {
		$disabled = array();
		$months_exist = $this->MonthSetModel->getListByMainSubject($this->main_subject_id);

		foreach ( $months_exist as $month ) {
			$month_compare = $month->getMonth()->format('m/d/Y');
			if(array_key_exists( $month_compare, $array )) {
				$disabled[] = $month_compare;
			}
		}
		return $disabled;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$month_select = $this->monthSelectGenerate();
		$this->getDisabled($month_select);

		if(!$this->id)
			$form
				->addSelect('month', 'Měsíc', $month_select)->setDisabled($this->getDisabled($month_select));

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');

		if( $this->id )
			$form->setDefaults($this->MonthSetModel->find($this->id, true));

		return $form;
	}

	/**
	 * @param Form $form
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 * @throws \Nette\Application\AbortException
	 */
	public function formSubmit( Form $form )
	{
		$data = $form->getValues(false);

		if($this->id) {
			$entity = $this->MonthSetModel->find($this->id);
		}
		else {
			$entity = new MonthSet();
			$entity->setMain_subject($this->MainSubjectModel->find($this->main_subject_id));
		}

		$entity->setLocked( false );
		if( !$this->id )
			$entity->setMonth( new \DateTime( $data->month ));


		if( $this->MonthSetModel->save($entity) ) {
			$this->presenter->flashMessage('Uloženo');
			$this->presenter->redirect('MonthSetHollidays:default', $entity->getId());
		}

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}