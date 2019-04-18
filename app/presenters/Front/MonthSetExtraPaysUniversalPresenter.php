<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 27.12.2018
 * Time: 14:12
 */

namespace App\FrontModule\Presenters;


use App\Component\Accounter\Form\IExtraPayUniversalFormFactory;
use App\Model\ExtraPayUniversalModel;

final class MonthSetExtraPaysUniversalPresenter extends BaseExtraPay
{
	/**
	 * @var IExtraPayUniversalFormFactory
	 * @inject
	 */
	public $extraPayUniversalFactory;

	/**
	 * @var ExtraPayUniversalModel
	 * @inject
	 */
	public $extraPayUniversalModel;

	public function createComponentForm()
	{
		$control = $this->extraPayUniversalFactory->create();
		return $control;
	}
	
	public function actionDefault( $mset )
	{
		parent::actionDefault($mset);
		$this['form']->setMonthSetId((int)$mset);

		$this->template->month_set = $this->monthSetModel->find((int)$mset);
		$this->template->pays = $this->month_set->extra_pays_universal;
		$this->addBreadcrumb('Ostatní nezařaditelné', 'this');
	}

	public function handleDelete( $extra_pay_id ) {
		$extra_pay = $this->extraPayUniversalModel->find((int)$extra_pay_id);
		if( !$extra_pay ) {
			$this->errorFlash('Příplatek nenalezen');
		}
		else {
			$this->extraPayUniversalModel->delete($extra_pay);
			$this->infoFlash('Příplatek smazán');
		}
		$this->redirect('this');
	}
}