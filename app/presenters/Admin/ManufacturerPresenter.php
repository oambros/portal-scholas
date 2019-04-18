<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16.01.2018
 * Time: 13:05
 */

namespace App\AdminModule\Presenters;


use App\Component\Manufacturer\Form\IManufacturerFormFactory;
use App\Model\ManufacturerModel;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;


class ManufacturerPresenter extends BasePresenter
{
	/**
	 * @var ManufacturerModel
	 * @inject
	 */
	public $manufacturerModel;

	/**
	 * @var IManufacturerFormFactory
	 * @inject
	 */
	public $manufacturerFormFactory;

	public function createComponentManufacturerForm() {
		return $this->manufacturerFormFactory->create();
	}

	public function actionEditManufacturer( $id )
	{
		$this['manufacturerForm']->setId($id);
	}

	public function actionAddManufacturer( )
	{

	}

	public function handleDeleteManufacturer( $id )
	{
		$manufacturer = $this->manufacturerModel->find($id);
		try {
			$this->manufacturerModel->delete($manufacturer);

		} catch ( ForeignKeyConstraintViolationException $e) {
			$this->flashMessage('Nelze smazat');
		}


		$this->redirect('this');
	}

	public function actionDefault()
	{
		$this->template->manufacturers = $this->manufacturerModel->getList();
	}
}