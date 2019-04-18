<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 09.04.2019
 * Time: 14:27
 */

namespace App\AdminModule\Presenters;


use App\Model\CommitmentModel;
use App\Model\EmployeeModel;
use App\Model\Entity\Commitment;
use App\Model\Entity\Employee;

abstract class BaseCommitment extends BasePresenter
{
	/**
	 * @var CommitmentModel
	 * @inject
	 */
	public $commitmentModel;

	/**
	 * @var EmployeeModel
	 * @inject
	 */
	public $employeeModel;

	/**
	 * @var Employee
	 */
	protected $employee = null;

	/**
	 * @var Commitment
	 */
	protected $commitment = null;

	public function beforeRender()
	{
		parent::beforeRender();
	}

	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Seznam subjektů', 'MainSubject:default');

	}

	public function actionEditCommitment( $commitment_id )
	{
		$this->commitment = $this->commitmentModel->find( (int)$commitment_id );
		$this->addBreadcrumb('Činnosti zaměstnance '.$this->commitment->getEmployee()->getFullName(), 'Commitment:default', $this->commitment->getEmployee()->getId());

	}

	public function actionDefault( $employee_id )
	{
		$this->employee = $this->employeeModel->find((int)$employee_id);
		$this->template->Employee = $this->employee;
		$this->addBreadcrumb('Činnosti zaměstnance '.$this->employee->getFullName(), 'Commitment:default', $this->employee->getId());

	}
}