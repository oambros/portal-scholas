<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 09.11.2018
 * Time: 12:01
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\IClientUserFormFactory;
use App\Model\ClientUserModel;
use App\Model\MainSubjectModel;

class ClientUserPresenter extends BaseClientUser
{

	/**
	 * @var IClientUserFormFactory
	 * @inject
	 */
	public $clientUserFormFactory;

	/**
	 * @var ClientUserModel
	 * @inject
	 */
	public $clientUserModel;

	/**
	 * @var MainSubjectModel
	 * @inject
	 */
	public $mainSubjectModel;

	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Seznam Subjektů', 'MainSubject:default');
	}

	/**
	 * @return \App\Component\Accounter\Form\ClientUserFormControl
	 */
	public function createComponentClientUserForm()
	{
		return $this->clientUserFormFactory->create();
	}

	public function actionDefault( $main_subject_id = null )
	{
		$this->addBreadcrumb('Přístupy');

		if( isset($main_subject_id) ) {
			$this->template->MainSubject = $this->mainSubjectModel->find($main_subject_id);
			$this->template->ClientUsers = $this->template->MainSubject->getClient_users();
		}

	}

	public function actionEditClientUser( $id )
	{
		$this['clientUserForm']->setId((int)$id);

	}

	public function actionAddClientUser( $main_subject_id )
	{
		$this['clientUserForm']->setMainSubjectId( $main_subject_id );
	}

	public function handleDeleteClientUser( $id )
	{
		$clientUser = $this->clientUserModel->find((int)$id);
		if( !$clientUser ) {
			$this->flashMessage('Uživatel nenalezen');

		}
		else {
			$this->clientUserModel->delete($clientUser);
			$this->flashMessage('Uživatel smazán');
		}
		$this->redirect('this');
	}
}