<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Forms\AdminSignFormFactory;
use Nette;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{
	/**
	 * @persistent
	 */
	public $backlink = "";

	/** @var AdminSignFormFactory @inject */
	public $factory;


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->factory->create();
		$form->onSuccess[] = function ($form) {
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
