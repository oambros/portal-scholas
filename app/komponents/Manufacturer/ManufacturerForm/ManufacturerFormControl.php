<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16.01.2018
 * Time: 12:51
 */

namespace App\Component\Manufacturer\Form;

use App\Model\Entity\ManufacturerEntity;
use App\Model\ManufacturerModel;
use Nette\Application\UI;

/**
 * Class ManufacturerFormControl
 * @package App\Component\Manufacturer\Form
 */
class ManufacturerFormControl extends UI\Control
{
	protected $id;

	/**
	 * @var ManufacturerModel
	 */
	protected $manufacturerModel;

	public function __construct( ManufacturerModel $manufacturerModel )
	{
		$this->manufacturerModel = $manufacturerModel;
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
		$form = new UI\Form();

		$form->addText('name', 'Jméno:');


		if( $this->id ) {
			$form->setDefaults($this->manufacturerModel->find($this->id, true));
		}

		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'onSubmit');
		return $form;
	}

	public function onSubmit( UI\Form $form )
	{
		$data = $form->getValues();
		if($this->id) {
			$manufacturer = $this->manufacturerModel->find($this->id);
		}
		else {
			$manufacturer = new ManufacturerEntity();
		}

		$manufacturer->setName( $data->name );


		if($this->manufacturerModel->save( $manufacturer )) {
			$this->presenter->flashMessage('Upraveno');
		}

		$this->presenter->redirect('Manufacturer:default');

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->render();
	}

}