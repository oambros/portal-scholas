<?php

namespace App\Component\Users\Forms;

use App\Model\Entity\Users;
use App\Model\UserManager;
use App\Model\UsersModel;
use Nette\Application\UI;
use Nette\Security\Passwords;

/**
 * Class UsersFormControl
 * @package App\Component\Users\Forms
 */
class UsersFormControl extends UI\Control
{
	protected $id = false;

	protected $self_user = false;

	/**
	 * @var UesrsModel
	 */
	protected $usersModel;

	/**
	 * @var UserManager
	 */
	protected $userManager;

	/**
	 * UsersFormControl constructor.
	 * @param UsersModel $usersModel
	 */
	public function __construct( UsersModel $usersModel, UserManager $userManager )
	{
		$this->usersModel = $usersModel;
		$this->userManager = $userManager;
	}
	/**
	 * @param integer $id
	 */
	public function setId( $id )
	{
		$this->id = (int)$id;
	}


	public function setSelfUser()
	{
		$this->self_user = true;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new UI\Form();

		$form->addText('f_name', 'Jméno:');
		$form->addText('l_name', 'Přijmení:');

		$form->addText('email', 'Email:');
		$form->addText('phone', 'Telefon:');
		$form->addText('street', 'Ulice:');
		$form->addText('city', 'Město:');
		$form->addText('zip', 'PSČ:');
		if( !$this->self_user ) {
			$form->addCheckbox('active', 'Aktivní:');

			$form->addCheckbox('superadmin', 'Superadmin:');

			$form->addSelect('type', 'Práva', array(1 => 'Administrátor', 2 => 'Řadový uživatel'));
		}

		if( $this->id ) {
			$form->setDefaults($this->usersModel->find($this->id, true));
		}

		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'onSubmit');
		return $form;
	}

	/**
	 * @return UI\Form
	 */
	public function createComponentPassForm()
	{
		$form = new UI\Form();

		$form
			->addPassword('pass', 'Heslo');

		$form
			->addPassword('pass2', 'Heslo znovu')
			->addRule(UI\Form::EQUAL, 'Hesla se neshodují', $form['pass'] );

		$form
			->addSubmit('submit', 'Změnit');

		$form->onSuccess[] = array($this, 'onSubmitPass');

		return $form;
	}

	public function onSubmitPass( UI\Form $form )
	{
		$data = $form->getValues();

		$user = $this->usersModel->find($this->id);

		$user->setPass(Passwords::hash($data->pass));

		$this->usersModel->save($user);

	}

	public function onSubmit( UI\Form $form )
	{
		$data = $form->getValues();
		if($this->id) {
			$user = $this->usersModel->find($this->id);

		}
		else {
			$user = new Users();
		}

		$user->setEmail( $data->email );
		$user->setF_name($data->f_name);
		$user->setL_name($data->l_name);
		$user->setPhone($data->phone);
		$user->setStreet($data->street);
		$user->setCity($data->city);
		$user->setZip($data->zip);


		if( !$this->self_user ) {

			$user->setType($data->type);

			if ($data->active != 1 && $this->id == 1) {
				$this->presenter->flashMessage('Nelze zneaktivnit výchozího uživatele!', 'error');
			} else {
				$user->setActive($data->active);
			}

			if ($data->superadmin != 1 && $this->id == 1) {
				$this->presenter->flashMessage('Tomuto uživateli nelze odebrat oprávnění supersprávce', 'error');
			} else {
				$user->setSuperadmin($data->superadmin);
			}
		}
		if($this->usersModel->save( $user )) {
			$this->presenter->flashMessage('Upraveno');
		}

		$this->presenter->redirect('Users:default');

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->render();
	}
}