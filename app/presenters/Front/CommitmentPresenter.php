<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 25.10.2018
 * Time: 23:33
 */

namespace App\FrontModule\Presenters;
use App\Component\Accounter\Form\ICommitmentFormFactory;
use App\Model\CommitmentModel;

/**
 * Class CommitmentPresenter
 * @package App\Presenters
 */
class CommitmentPresenter extends BasePresenter
{

	/**
	 * @var CommitmentModel
	 * @inject
	 */
	public $commitmentModel;

	/**
	 * @var ICommitmentFormFactory
	 * @inject
	 */
	public $commitmentFormFactory;

	/**
	 * @return \App\Component\Accounter\Form\CommitmentFormControl
	 */
	public function createComponentCommitmentForm()
	{
		return $this->commitmentFormFactory->create();
	}

	/**
	 * @param $employee_id
	 */
	public function actionDefault( $employee_id ) {
		$this->template->employee_id = (int)$employee_id;
		$this->template->commitments = $this->commitmentModel->getCommitmentsByEmployee( (int)$employee_id );
	}

	public function actionAddCommitment( $employee_id ) {
		$this['commitmentForm']->setEmployeeId((int)$employee_id);
	}

	public function actionEditCommitment( $commitment_id ) {
		$this['commitmentForm']->setId((int)$commitment_id);
	}
}