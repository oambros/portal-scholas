<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 14.02.2019
 * Time: 11:17
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\IFinancingFormFactory;

final class FinancingPresenter extends BaseFinancing
{
	/**
	 * @var IFinancingFormFactory
	 * @inject
	 */
	public $financingFormFactory;

	public function __construct()
	{
		parent::__construct();
	}

	public function createComponentForm()
	{
		$control = $this->financingFormFactory->create();
		return $control;
	}

	public function actionDefault( $id )
	{
		parent::actionDefault($id);
	}

	public function actionAdd( $id )
	{
		parent::actionDefault( $id );
		$this->addBreadcrumb('Přidej druh financování '.$this->main_sunject->getName());

		$this['form']->setSubjectId( (int)$id );
	}
}