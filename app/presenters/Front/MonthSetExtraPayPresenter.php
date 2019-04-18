<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 15.04.2019
 * Time: 0:50
 */

namespace App\FrontModule\Presenters;


use App\Component\Accounter\Form\IExtraPayFormFactory;

final class MonthSetExtraPayPresenter extends BaseExtraPay
{
	/**
	 * @var IExtraPayFormFactory
	 * @inject
	 */
	public $extraPayFormFactory;

	public function createComponentForm()
	{
		$control = $this->extraPayFormFactory->create();
		$control->setMonthSetId((int)$this->month_set->getId());
		$control->setExtraPayTypeId((int)$this->extra_pay_type_id);
		return $control;
	}

	public function actionDefault( $mset, $type = 1 )
	{
		parent::actionDefault( $mset );

		$this->extra_pay_type_id = $type;
		$this->template->extra_pay_type = $this->extraPayTypeModel->find((int)$type);
		$this->template->extra_pay_type_id = $this->extra_pay_type_id;
		$this->template->extra_pays = $this->extraPayModel->getListByMsetExtraPayType($mset, $type);
		$this->addBreadcrumb($this->template->extra_pay_type->getName(), 'this');
	}

	public function handleDelete( $id )
	{
		$extraPay = $this->extraPayModel->find((int)$id);
		if( !$extraPay ) {
			$this->errorFlash('Příplatek nenalezen!');
			$this->redirect('this');
		}

		$this->extraPayModel->delete($extraPay);
		$this->infoFlash('Smazáno');
		$this->redirect('this');
	}
}