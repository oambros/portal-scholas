<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 18.02.2018
 * Time: 0:36
 */

namespace App\AdminModule\Forms;


use App\Model\UserManager;
use Nette\Application\UI\Form;
use Nette\Object;
use Nette\Security\User;

class RegisterFormFactory extends Object
{
	/** @var User */
	private $user;

	/**
	 * @var UserManager
	 */
	protected $userManager;

	public function __construct(User $user, UserManager $userManager)
	{
		$this->user = $user;
		$this->userManager = $userManager;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form();
		$form->addText('email', 'email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form
			->addPassword('password2', 'Password:')
			->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);


		$form->addSubmit('send', 'register');

		$form->onSubmit[] = array($this, 'formSucceeded');

		return $form;
	}

	public function formSucceeded(Form $form)
	{
		$data = $form->getValues();
		$this->userManager->add($data->email, $data->password);
		$form->addError('Přidáno');
	}
}