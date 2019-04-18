<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16.10.2018
 * Time: 14:42
 */

namespace App\AdminModule\Presenters;


use App\Model\MainSubjectModel;

class AccounterPresenter extends BasePresenter
{
	/**
	 * @var MainSubjectModel
	 * @inject
	 */
	public $mainSubjectModel;

	public function actionDefault()
	{
		$this->template->main_subjects = $this->mainSubjectModel->getList();
	}
}