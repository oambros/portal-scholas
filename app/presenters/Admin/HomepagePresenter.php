<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Forms\AdminSignFormFactory;
use App\AdminModule\Forms\RegisterFormFactory;
use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	/**
	 * @var AdminSignFormFactory
	 * @inject
	 */
	public $adminSignFormFactory;

	/**
	 * @var RegisterFormFactory
	 * @inject
	 */
	public $registerFormFactory;

	/**
	 * @var Model\GdprSubjectModel
	 * @inject
	 */
	public $gdprSubjectModel;

	public function renderDefault()
	{
		$this->page_title = 'Home';
	}

	public function createComponentSignForm()
	{
		$control =  $this->adminSignFormFactory->create();
		$control->onSuccess[] = function (Nette\Application\UI\Form $form) {
			$this->redirect('Homepage:default');
		};
		return$control;
	}

	public function createComponentRegisterForm()
	{
		return $this->registerFormFactory->create();
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

	public function actionDefault()
	{
		$this->template->home_subjects_sign = $this->gdprSubjectModel->getList(array('sign' => true));
		$this->template->home_subjects_unsign = $this->gdprSubjectModel->getList(array('sign' => false));
	}

}
