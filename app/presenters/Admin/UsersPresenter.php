<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 11:50
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\ISubject4UserFormFactory;
use App\Component\Users\Forms\IUsersFormFactory;

class UsersPresenter extends BasePresenter
{
	/**
	 * @var IUsersFormFactory
	 * @inject
	 */
	public $usersFormFactory;


	/**
	 * @var ISubject4UserFormFactory
	 * @inject
	 */
	public $subject4UserFactory;

	/**
	 * @return \App\Component\Users\Forms\UsersFormControl
	 */
	public function createComponentUsersForm()
	{
		return $this->usersFormFactory->create();
	}

	public function createComponentSubject4UsersForm()
	{
		return $this->subject4UserFactory->create();
	}
	
	public function actionDefault()
	{
		$this->superadminCheck('Nemáte oprávnění přístupu do této sekce');
		$this->template->users = $this->usersModel->getList();
	}

	public function actionAddUser()
	{
		$this->superadminCheck('Nemáte oprávnění přístupu do této sekce');
	}

	public function actionEditMyAccount()
	{
		$this->template->user = $this->user->getIdentity();
		$this['usersForm']->setId((int)$this->template->user->getId());
		$this['usersForm']->setSelfUser();
	}

	public function actionEditUser( $id )
	{
		$this->superadminCheck('Nemáte oprávnění přístupu do této sekce');
		$this['usersForm']->setId((int)$id);
	}
	
	public function actionUserMainSubjects( $id )
	{
		$this->template->User = $this->usersModel->find((int)$id);
		$this->template->Subjects = $this->template->User->getMain_subjects();
	}

	public function actionAddSubject4User( $id )
	{
		$this['subject4UsersForm']->setUserId((int)$id);
	}
	
	public function handleDeleteUser( $id )
	{

		$this->superadminCheck('Nemáte oprávnění k mazání uživatelů!');
		$user = $this->usersModel->find($id);
		$this->usersModel->delete( $user );
		$this->redirect('Users:default');


	}
	
	protected function superadminCheck( $flash_message = 'chyba přístupu' )
	{
		if( !$this->user->getIdentity()->superadmin ) {
			$this->flashMessage($flash_message, 'danger');
			$this->redirect('Homepage:default');
		}
	}
}