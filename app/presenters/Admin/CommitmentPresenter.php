<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 25.10.2018
 * Time: 23:33
 */

namespace App\AdminModule\Presenters;

use App\Component\Accounter\Form\ICommitmentFormFactory;
use App\Model\CommitmentModel;
use App\Model\Entity\Commitment;

/**
 * Class CommitmentPresenter
 * @package App\Presenters
 */
final class CommitmentPresenter extends BaseCommitment
{
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
		$control = $this->commitmentFormFactory->create();
		$control->onSaveNew[] = function ( Commitment $commitment )
		{
			$this->flashMessage('Uloženo');
			$this->redirect('this');
		};
		return $control;
	}

	/**
	 * @param $employee_id
	 */
	public function actionDefault($employee_id)
	{
		parent::actionDefault($employee_id);
		$this->template->commitments = $this->commitmentModel->getCommitmentsByEmployee((int)$employee_id);

	}

	public function actionAddCommitment($employee_id)
	{
		parent::actionDefault($employee_id);
		$employee = $this->employeeModel->find((int)$employee_id);

		if (!$employee) {
			$this->errorFlash('Zaměstnanec id:' . $employee_id . ' nenalezen');
			$this->redirect('MainSubject:default');
		}
		$this['commitmentForm']->setEmployeeId((int)$employee_id);
		$this->addBreadcrumb('Přidej činnost', null);
	}

	public function actionEditCommitment($commitment_id)
	{   parent::actionEditCommitment( $commitment_id );

		$this->addBreadcrumb('Uprav činnost '.$this->commitment->getName(), null);
		$this['commitmentForm']->setId((int)$commitment_id);
	}

	/**
	 * @param $id
	 * @throws \Nette\Application\AbortException
	 */
	public function handleDelete($id)
	{
		$commitment = $this->commitmentModel->find((int)$id);
		if (!$commitment) {
			$this->errorFlash('Úvazek nebyl nalezen');
		} else {
			$this->commitmentModel->delete($commitment);
			$this->infoFlash('Smazáno');
		}
		$this->redirect('this');
	}
}