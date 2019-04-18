<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 25.10.2018
 * Time: 11:20
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\EmployeeFormControl;
use App\Component\Accounter\Form\IEmployeeFormFactory;
use App\Model\EmployeeModel;
use App\Model\Entity\Employee;
use App\Model\MainSubjectModel;

final class EmployeePresenter extends BaseEmployee
{
	/**
	 * @var EmployeeModel
	 * @inject
	 */
	public $employeeModel;

	/**
	 * @var MainSubjectModel
	 * @inject
	 */
	public $mainSubjectModel;

	/**
	 * @var IEmployeeFormFactory
	 * @inject
	 */
	public $employeeFormFactory;

	/**
	 * @return EmployeeFormControl
	 */
	public function createComponentEmployeeForm()
	{
		$control = $this->employeeFormFactory->create();
		/**
		 * @param Employee $employee
		 * @throws \Nette\Application\AbortException
		 */
		$control->onSaveEmployee[] = function (Employee $employee ) {
			$this->flashMessage('Zaměstnanec '.$employee->getFullName().' vložen');
			$this->redirect('Commitment:addCommitment', ['employee_id' => $employee->getId()]);
		};
		return $control;
	}

	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Seznam subjektů', 'MainSubject:default');

	}

	public function actionDefault( $main_subject_id = null )
	{
		parent::actionDefault();
		$this->template->main_subject_id = $main_subject_id;

		if( !$main_subject_id ) {
			$this->template->employees = $this->employeeModel->getList();
		}
		else {
			$this->template->employees = $this->employeeModel->getListByMainSubject((int)$main_subject_id);
			$this->template->main_subject = $this->mainSubjectModel->find((int)$main_subject_id);
		}
	}

	public function actionAddEmployee( $main_subject_id )
	{
		$this['employeeForm']->setSubjectId((int)$main_subject_id );
		$this->template->main_subject = $this->mainSubjectModel->find((int)$main_subject_id);
	}

	public function actionEditEmployee( $id )
	{
		$this['employeeForm']->setId((int)$id);
	}

	public function handleDeleteEmployee( $id )
	{
		$entity = $this->employeeModel->find((int)$id);
		$this->employeeModel->delete($entity);
		$this->flashMessage('Zaměstnanec smazán');
		$this->redirect('this');
	}
}