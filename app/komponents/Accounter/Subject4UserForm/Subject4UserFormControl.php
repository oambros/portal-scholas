<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:14
 */

namespace App\Component\Accounter\Form;


use App\Model\ClientUserModel;
use App\Model\MainSubjectModel;
use App\Model\UsersModel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class Subject4UserFormControl extends Control
{
	/**
	 * @var integer
	 */
	protected $user_id = 0;

	/**
	 * @var UsersModel
	 */
	protected $userModel;

	/**
	 * @var MainSubjectModel
	 */
	protected $mainSubjectModel;

	/**
	 * ClientUserFormControl constructor.
	 * @param ClientUserModel $clientUserModel
	 */
	public function __construct(UsersModel $usersModel, MainSubjectModel $mainSubjectModel)
	{
		$this->userModel = $usersModel;
		$this->mainSubjectModel = $mainSubjectModel;
	}

	/**
	 * @param $id
	 */
	public function setUserId($id)
	{
		$this->user_id = (int)$id;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$main_subjects_select = $this->mainSubjectModel->getSelectList();
		$main_subjects_from_user = $this->userModel->find($this->user_id)->getMain_subjects();

		$main_subjects_default = array();

		foreach ($main_subjects_from_user as $item) {
			$main_subjects_default[] = $item->getId();
		}

		$form
			->addCheckboxList('main_subjects', 'Subjekty uživatele', $main_subjects_select)
			->setDefaultValue($main_subjects_default);

		$form
			->addSubmit('submit', 'Ulož');

		$form->onSuccess[] = array($this, 'formSubmit');


		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSubmit(Form $form)
	{
		$data = $form->getValues(false);
		$entity = $this->userModel->find($this->user_id);

		//$entity->clearMainSubjects();

		foreach ( $data->main_subjects as $subject_id ) {
			$entity->addMain_subject( $this->mainSubjectModel->find($subject_id) );
		}

		$this->userModel->save($entity);

		$this->presenter->redirect('this');


	}

	public function render()
	{
		$template = $this->createTemplate();

		$template->setFile(__DIR__ . '/form.latte');
		$template->render();
	}
}