<?php

namespace App\AdminModule\Presenters;

use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/**
	 * @persistent
	 */
	public $backlink = "";

	public $page_title = null;

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
	 * @var Model\LogModel
	 * @inject
	 */
	public $logModel;

	public $action_name = null;

	public $bread_crumbs = [];

	public function startup()
	{
		parent::startup();

		$this->user->getStorage()->setNamespace('Admin');

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
			}

		}


	}

	public function beforeRender()
	{
		//kvuli profiwh
		//$this->template->basePath = $this->template->basePath.'/www';
		if(!$this->page_title) {
			$this->action_name = $this->getName().':'.$this->getAction();
			$this->page_title = $this->pageTextModel->getPageText($this->action_name);
		}
		$this->template->action_name = $this->action_name;
		$this->template->page_title = $this->page_title;
		$this->template->UserData = $this->user->getIdentity();
		$this->template->bread_crumbs = $this->bread_crumbs;
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
