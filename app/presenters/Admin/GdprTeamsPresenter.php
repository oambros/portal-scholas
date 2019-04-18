<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.03.2018
 * Time: 22:41
 */

namespace App\AdminModule\Presenters;


use App\Component\Gdpr\Form\IGdprTeamFormFactory;
use App\Model\GdprTeamsModel;

class GdprTeamsPresenter extends BasePresenter
{
	/**
	 * @var GdprTeamsModel
	 * @inject
	 */
	public $gdprTeamModel;

	/**
	 * @var IGdprTeamFormFactory
	 * @inject
	 */
	public $gdprTeamFormFactory;

	/**
	 * @return \App\Component\Gdpr\Form\GdprTeamFormControl
	 */
	public function createComponentGdprTeamForm()
	{
		$form = $this->gdprTeamFormFactory->create();
		return $form;
	}
	
	public function actionDefault()
	{
		$this->template->teams = $this->gdprTeamModel->getList();
	}

	public function actionAddTeam()
	{

	}
	
	public function actionEditTeam($id)
	{
		$this['gdprTeamForm']->setId((int)$id);
	}
}