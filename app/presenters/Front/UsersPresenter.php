<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 11:50
 */

namespace App\FrontModule\Presenters;


use App\Component\Users\Forms\IUsersFormFactory;

class UsersPresenter extends BasePresenter
{
	/**
	 * @var IUsersFormFactory
	 * @inject
	 */
	public $usersFormFactory;

	/**
	 * @return \App\Component\Users\Forms\UsersFormControl
	 */
	public function createComponentUsersForm()
	{
		return $this->usersFormFactory->create();
	}
	
	public function actionDefault()
	{
		$this->template->users = $this->usersModel->get();
	}



}