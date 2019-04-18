<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 15.04.2019
 * Time: 11:04
 */

namespace App\FrontModule\Presenters;


use App\Model\EmployeeModel;

abstract class BaseEmployee extends BasePresenter
{
	/**
	 * @var EmployeeModel
	 * @inject
	 */
	public $employeeModel;

	public function __construct()
	{
		parent::__construct();
		$this->addBreadcrumb('Zaměstanci', 'Employee:default');
	}
}