<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 15.04.2019
 * Time: 11:23
 */

namespace App\FrontModule\Presenters;


use App\Model\MainSubjectModel;

final class KontaktyPresenter extends BasePresenter
{
	/**
	 * @var MainSubjectModel
	 * @inject
	 */
	public $mainSubjectModel;

	public function actionDefault() {
		$main_subject = $this->mainSubjectModel->find((int)$this->main_subject_id);
		$this->template->Users = $main_subject->users;
		$this->addBreadcrumb('Kontakty', 'Kontakty:default');
	}
}