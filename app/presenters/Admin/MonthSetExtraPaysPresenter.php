<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 27.12.2018
 * Time: 14:06
 */

namespace App\AdminModule\Presenters;


use App\Component\Accounter\Form\IExtraPayFormFactory;
use App\Model\ExtraPayTypeModel;

class MonthSetExtraPaysPresenter extends BaseMonthSetExtraPays
{
	/**
	 * @var null
	 */
	protected $mset_id = null;

	/**
	 * @var null
	 */
	protected $extra_pay_type_id = null;

	/**
	 * @var IExtraPayFormFactory
	 * @inject
	 */
	public $extraPayFormFactory;

	/**
	 * @var ExtraPayTypeModel
	 * @inject
	 */
	public $extraPayTypeModel;

	public function createComponentForm()
	{
		$control = $this->extraPayFormFactory->create();
		$control->setMonthSetId((int)$this->mset_id);
		$control->setExtraPayTypeId((int)$this->extra_pay_type_id);
		return $control;
	}

	public function actionDefault( $mset, $type = 1 )
	{
		parent::actionDefault($mset);
		$this->extra_pay_type_id = $type;
		$this->template->extra_pay_type = $this->extraPayTypeModel->find((int)$type);
		$this->template->extra_pay_type_id = $this->extra_pay_type_id;
		$this->template->extra_pays = $this->extraPayModel->getListByMsetExtraPayType($mset, $type);
	}
}