<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.03.2018
 * Time: 22:16
 */

namespace App\Component\Gdpr\Form;


use App\Model\Entity\GdprTeam;
use App\Model\GdprTeamsModel;
use App\Model\UsersModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class GdprTeamFormControl extends Control
{
	protected $id = false;

	/**
	 * @var GdprTeamsModel
	 */
	protected $gdprTeamsModel;

	/**
	 * @var UsersModel
	 */
	protected $users;

	/**
	 * GdprTeamFormControl constructor.
	 * @param GdprTeamsModel $gdprTeamsModel
	 * @param UsersModel $users
	 */
	public function __construct(GdprTeamsModel $gdprTeamsModel, UsersModel $users)
	{
		$this->gdprTeamsModel = $gdprTeamsModel;
		$this->users = $users;
	}

	public function setId($id)
	{
		$this->id = (int)$id;
	}


	public function createComponentForm()
	{
		$form = new Form();

		$form
			->addText('name', 'Jméno teamu')
			->addRule(Form::FILLED, 'Musíte zadat název teamu');

		$form
			->addTextArea('note', 'Poznámka');

		$form
			->addCheckboxList('users', 'Uživatelé', $this->users->getCheckboxList());

		$form
			->addRadioList('type', 'Barva', array(1 => 'červený', 2 => 'žlutý', 3 => 'modrý', 4 => 'zelený', 5 => 'fialový'));

		$form
			->addSubmit('submit', 'Uložit');

		if( $this->id ){
			$defaults = $this->gdprTeamsModel->find($this->id, true);

			$form
				->setDefaults($defaults);
		}


		$form->onSuccess[] = array($this, 'formProcess');

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formProcess( Form $form )
	{
		$data = $form->getValues();

		if( $this->id ) {
			$team = $this->gdprTeamsModel->find($this->id);
		}
		else {
			$team = new GdprTeam();
		}

		$team->setName($data->name);
		$team->setNote($data->note);
		$team->setType($data->type);

		$team->clearUsers();

		foreach ( $data->users as $id_user ) {
			$team->addUser($this->users->find($id_user));
		}

		$this->gdprTeamsModel->save($team);

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->render();
	}

}

interface IGdprTeamFormFactory {
	/**
	 * @return GdprTeamFormControl
	 */
	function create();
}