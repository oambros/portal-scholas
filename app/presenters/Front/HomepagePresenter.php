<?php

namespace App\FrontModule\Presenters;

use App\FrontModule\Forms\FrontSignFormFactory;
use Nette;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	/**
	 * @var FrontSignFormFactory
	 * @inject
	 */
	public $frontSignFormFactory;

	public function renderDefault()
	{
		$this->page_title = 'Home';
	}

	public function createComponentSignForm()
	{
		$control =  $this->frontSignFormFactory->create();
		$control->onSuccess[] = function (Nette\Application\UI\Form $form) {
			$this->redirect('Homepage:default');
		};
		return$control;
	}

	public function actionLogin()
	{
		$this->setLayout('login_layout');
	}

	public function actionLogout()
	{
		if($this->user->isLoggedIn()) {
			$this->user->logout();
			$this->flashMessage('Byl jste odhlášen', 'success');
			$this->redirect('Homepage:login');
		}
	}

	public function actionRegister()
	{
		$this->setLayout('login_layout');
	}


}
