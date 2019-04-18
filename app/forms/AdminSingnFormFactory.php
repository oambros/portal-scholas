<?php

namespace App\AdminModule\Forms;

use App\Model\UserManager;
use Nette,
	Nette\Application\UI\Form,
	Nette\Security\User;

class AdminSignFormFactory extends Nette\Object
{
	/** @var User */
	private $user;

	public function __construct(User $user, UserManager $autenticator)
	{
		$this->user = $user;
		$user->getStorage()->setNamespace('Admin');
		$user->setAuthenticator($autenticator);
	}


	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Zadejte email.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte heslo.');

		$form->addCheckbox('remember', 'Pamatuj si mě');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}


	public function formSucceeded($form, $values)
	{
		if ($values->remember) {
			$this->user->setExpiration('14 days', FALSE);
		} else {
			$this->user->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->user->login($values->email, $values->password, 'admin');
		} catch (Nette\Security\AuthenticationException $e) {

			$form->addError($e->getMessage());
		}
	}


}
