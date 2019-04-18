<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.10.2018
 * Time: 11:17
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\IMainSubjectFormFactory;
use App\Model\MainSubjectModel;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class MainSubjectPresenter extends BasePresenter
{
	/**
	 * @var MainSubjectModel
	 * @inject
	 */
	public $mainSubjectModel;

	/**
	 * @var IMainSubjectFormFactory
	 * @inject
	 */
	public $mainSubjectFormFactory;

	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * @return \App\Component\Accounter\Form\MainSubjectFormControl
	 */
	public function createComponentMainSubjectForm()
	{
		return $this->mainSubjectFormFactory->create();
	}
 
	public function actionAddMainSubject( )
	{

	}

	public function actionEditMainSubject($id)
	{
		$this['mainSubjectForm']->setId((int)$id);
	}

	public function actionDefault( $search = null )
	{
		$this->addBreadcrumb('Seznam subjektů');

		if ( $search ){
			if( strlen( $search ) < 3 ) {
				$this->errorFlash('Musíte zadat alespoň 3 znaky!');
				$this->redirect( 'MainSubject:default' );
			}
		}

		if( $this->getUser()->getIdentity()->superadmin ) {
			if( $search ){
				$this->template->main_subjects = $this->mainSubjectModel->getListByNameLike( $search );
				if( count($this->template->main_subjects) == 0 )
					$this->errorFlash('Pro hledavý text <strong>"'.$search.'"</strong> jsme nic nenalezli :(');
			}

			else
				$this->template->main_subjects = $this->mainSubjectModel->getList();
		}
		else
			$this->template->main_subjects = $this->usersModel->find( $this->user->getIdentity()->id )->getMain_subjects();
	}

	/**
	 * @param $id
	 * @throws \Nette\Application\AbortException
	 */
	public function handleDelete( $id )
	{
		$entity = $this->mainSubjectModel->find((int)$id);
		if(!$entity)
			$this->flashMessage('Subjekt nenalezen');

		$catch = false;

		try {
			$this->mainSubjectModel->delete($entity);

		} catch (ForeignKeyConstraintViolationException $e) {
			$this->errorFlash('Nelze smazat, na subjekt jsou vázány další záznamy');
			$catch = true;
		}
		if(!$catch)
			$this->flashMessage('Subjekt smazán');

		$this->redirect('this');
	}

	/**
	 * @param $string
	 * @throws \Nette\Application\AbortException
	 */
	public function handleSearch( $string )
	{
		$this->redirect( 'MainSubject:default', array('search' => $string) );
	}
}