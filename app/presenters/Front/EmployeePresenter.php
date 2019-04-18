<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 25.10.2018
 * Time: 11:20
 */

namespace App\FrontModule\Presenters;


use App\Component\Accounter\Form\EmployeeFormControl;
use App\Component\Accounter\Form\IEmployeeFormFactory;
use App\Model\EmployeeModel;
use App\Model\MainSubjectModel;

class EmployeePresenter extends BaseEmployee
{
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
		return $this->employeeFormFactory->create();
	}

	public function actionDefault( )
	{
		$this->template->main_subject_id = $this->main_subject_id;

		$this->template->employees = $this->employeeModel->getListByMainSubject((int)$this->main_subject_id);
		$this->template->main_subject = $this->mainSubjectModel->find((int)$this->main_subject_id);
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

	public function actionShowEmployee( $id )
	{
		$employee = $this->employeeModel->find((int)$id);

		if( !$employee ) {
			$this->errorFlash('Zaměstanec nenalezen!');
			$this->redirect('Employee:default');
		}

		$this->template->Employee = $employee;
		$this->addBreadcrumb('Zaměstnanec '.$employee->getFullName(), 'Employee:ShowEmployee', $employee->getId());
	}
}