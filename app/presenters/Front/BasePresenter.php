<?php

namespace App\FrontModule\Presenters;

use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	public $page_title = null;

	public $action_name = null;

	public $bread_crumbs = [];

	/**
	 * @var Model\UsersModel
	 * @inject
	 */
	public $usersModel;

	/**
	 * @var Model\PageTextModel
	 * @inject
	 */
	public $pageTextModel;

	/**
	 * @var Model\ClientUserModel
	 * @inject
	 */
	public $clientUserModel;

	/**
	 * @var Model\LogModel
	 * @inject
	 */
	public $logModel;

	public $main_subject_id = null;

	public function startup()
	{
		parent::startup();

		$this->user->getStorage()->setNamespace('Front');

		if($this->action == 'register') {

		}
		else {

			if( $this->action != 'refreshSubjects' ) {
				if(!$this->user->isLoggedIn()) {
					if($this->action != 'login') {
						$this->flashMessage('Musíte se přihlásit', 'danger');
						$this->redirect('Homepage:login');

					}

				}
				else {
					$this->main_subject_id = $this->clientUserModel->find((int)$this->user->id)->main_subject->id;

				}
			}

		}


	}

	public function beforeRender()
	{
		//kvuli profiwh
		//$this->template->basePath = $this->template->basePath.'/www';
		if(!$this->page_title) {
			$this->page_title = $this->pageTextModel->getPageText($this->getName().':'.$this->getAction());
			$this->action_name = $this->getName().':'.$this->getAction();

		}
		$this->template->user = $this->user->getIdentity();
		$this->template->bread_crumbs = $this->bread_crumbs;
		$this->template->page_title = $this->page_title;
		$this->template->action_name = $this->action_name;

	}

	public function errorFlash( $string )
	{
		$this->flashMessage($string, 'alert alert-danger');
	}

	public function successFlash( $string )
	{
		$this->flashMessage($string, 'alert alert-success');
	}

	public function infoFlash( $string )
	{
		$this->flashMessage($string, 'alert alert-info');
	}

	/**
	 * @param null $title
	 * @param null $link
	 */
	public function addBreadcrumb( $title = null, $link = null, $param = null )
	{
		$this->bread_crumbs[] = array('title' => $title, 'link' => $link, 'link_param' => $param);
	}

}
