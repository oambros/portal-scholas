<?php

namespace App\FrontModule\Forms;

use App\Model\ClientUserManager;
use App\Model\UserManager;
use Nette,
	Nette\Application\UI\Form,
	Nette\Security\User;


class FrontSignFormFactory extends Nette\Object
{
	/** @var User */
	private $user;

	public function __construct(User $user, UserManager $autenticator)
	{
		$this->user = $user;
		$user->getStorage()->setNamespace('Front');
		$user->setAuthenticator($autenticator);
	}


	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->addText('login', 'login:')
			->setRequired('Zadejte login.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte heslo.');

		$form->addCheckbox('remember', 'Pamatuj si mě');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}


	public function formSucceeded($form, $values)
	{
		$this->user->getStorage()->setNamespace('Front');
		if ($values->remember) {
			$this->user->setExpiration('14 days', FALSE);
		} else {
			$this->user->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->user->login($values->login, $values->password, 'front');
		} catch (Nette\Security\AuthenticationException $e) {

			$form->addError($e->getMessage());
		}
	}


}
