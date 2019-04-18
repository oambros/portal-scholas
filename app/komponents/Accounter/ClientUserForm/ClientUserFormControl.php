<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;


use App\Model\ClientUserModel;
use App\Model\Entity\ClientUser;
use App\Model\MainSubjectModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Security\Passwords;

class ClientUserFormControl extends Control
{
	/**
	 * @var integer
	 */
	protected $id = 0;

	/**
	 * @var integer
	 */
	protected $main_subject_id = 0;

	/**
	 * @var ClientUserModel
	 */
	protected $clientUserModel;

	/**
	 * @var MainSubjectModel
	 */
	protected $mainSubjectModel;

	/**
	 * ClientUserFormControl constructor.
	 * @param ClientUserModel $clientUserModel
	 */
	public function __construct(ClientUserModel $clientUserModel, MainSubjectModel $mainSubjectModel)
	{
		$this->clientUserModel = $clientUserModel;
		$this->mainSubjectModel = $mainSubjectModel;
	}

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
	}

	public function setMainSubjectId($id)
	{
		$this->main_subject_id = (int)$id;
	}

	public function createComponentPassForm()
	{
		$form = new Form();

		$form
			->addHidden('client_user_id')
			->setDefaultValue($this->id);

		$form
			->addPassword('pass', 'Heslo:')
			->setRequired('Musíte zadat heslo');

		$form
			->addPassword('pass2', 'Heslo znovu')
			->setRequired('Musíte vyplnit validaci hesla')
			->addRule(Form::EQUAL, 'Hesla se musí shodovat', $form['pass']);

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formPassSubmit');

		return $form;
	}

	public function formPassSubmit( Form $form )
	{
		$data = $form->getValues();

		$entity = $this->clientUserModel->find((int)$data->client_user_id);

		if( $data->pass == $data->pass2 ) {
			$entity->setPass(Passwords::hash($data->pass));

			$this->clientUserModel->save($entity);

			$this->sendPassChangeEmail($entity, $data->pass);

			$this->presenter->flashMessage('Heslo upraveno', 'info');
			$this->presenter->redirect('ClientUser:default', $entity->getMain_subject()->id);

		}
		else {

			$this->presenter->flashMessage("Hesla nejsou stejná");
			//$this->presenter->redirect('this');
		}


	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form
			->addText('login', 'Login')
			->setRequired('Musíte zadat login');

		$form
			->addText('email', 'Email')
			->setRequired('Musíte zadat email')
			->addRule(Form::EMAIL, 'Špatý formát emailu');

		if( $this->main_subject_id )
			$form->addHidden('main_subject_id')->setDefaultValue($this->main_subject_id);

		$form
			->addCheckbox('active', 'Aktivní');

		if(!$this->id) {
			$form
				->addPassword('pass', 'Heslo:')
				->setRequired('Musíte zadat heslo');

			$form
				->addPassword('pass2', 'Heslo znovu')
				->addRule(Form::EQUAL, 'Hesla se musí shodovat', $form['pass']);
		}

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');

		if ($this->id) {
			$form->setDefaults($this->clientUserModel->find($this->id, true));

		}
		else {
			$form['login']->setDefaultValue( $this->clientUserModel->createUserLogin());
		}


		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit(Form $form)
	{
		$data = $form->getValues(false);

		if ($this->id) {
			$entity = $this->clientUserModel->find($this->id);

		} else {
			$entity = new ClientUser();
			$entity->setMain_subject( $this->mainSubjectModel->find((int)$data->main_subject_id) );
		}



		if( !$this->clientUserModel->testUniqueLogin( $data->login, $this->id ) ) {
			$this->presenter->flashMessage('Login není unikátní!', 'error');
			$this->presenter->redirect('this');
		}

		$entity->setLogin( $data->login );
		$entity->setEmail( $data->email );
		$entity->setActive( $data->active );

		if(!$this->id)
			$entity->setPass( Passwords::hash($data->pass) );

		$this->clientUserModel->save($entity);

		$this->sendRegEmail($entity, $data->pass);

		$this->presenter->redirect('ClientUser:default', array('main_subject_id' => $entity->main_subject->id));


	}

	/**
	 * @param ClientUser $clientUser
	 * @param null $pass
	 * @return bool
	 */
	protected function sendRegEmail( ClientUser $clientUser, $pass = null ) {
		$template = $this->createTemplate();

		$template->setFile(__DIR__.'/EmailFormTemplate.latte');

		$template->email = $clientUser->getEmail();
		$template->login = $clientUser->getLogin();
		$template->pass = $pass;
		$template->MainSubject = $clientUser->getMain_subject()->name;

		$message = new Message();
		$message->addTo($clientUser->getEmail());

		$message->setFrom('info@scholaservis.cz');
		$message->setSubject('Zpráva z portálu scholaservis.cz, registrace');
		$message->setHtmlBody($template);

		$sender = new SendmailMailer();
		if($sender->send($message)) {
			return true;
		}
		return false;
	}

	/**
	 * @param ClientUser $clientUser
	 * @param null $pass
	 * @return bool
	 */
	protected function sendPassChangeEmail( ClientUser $clientUser, $pass = null ) {
		$template = $this->createTemplate();

		$template->setFile(__DIR__.'/EmailFormChangePass.latte');

		$template->email = $clientUser->getEmail();
		$template->login = $clientUser->getLogin();
		$template->pass = $pass;
		$template->MainSubject = $clientUser->getMain_subject()->name;

		$message = new Message();
		$message->addTo($clientUser->getEmail());

		$message->setFrom('info@scholaservis.cz');
		$message->setSubject('Zpráva z portálu scholaservis.cz, změna hesla');
		$message->setHtmlBody($template);

		$sender = new SendmailMailer();
		if($sender->send($message)) {
			return true;
		}
		return false;
	}

	public function render()
	{
		$template = $this->createTemplate();

		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}