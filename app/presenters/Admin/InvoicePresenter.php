<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.01.2018
 * Time: 22:34
 */

namespace App\AdminModule\Presenters;


use App\Component\Invoices\Form\IInvoiceFormFactory;
use App\Model\InvoiceModel;

class InvoicePresenter extends BasePresenter
{
	/**
	 * @var InvoiceModel
	 * @inject
	 */
	public $invoiceModel;

	/**
	 * @var IInvoiceFormFactory
	 * @inject
	 */
	public $invoiceFormFactory;

	public function createComponentInvoiceForm()
	{
		return $this->invoiceFormFactory->create();
	}

	public function actionDefault()
	{
		$this->template->invoices = $this->invoiceModel->getList();
	}

	public function actionAddInvoice()
	{

	}

	public function actionEditInvoice($id)
	{
		$this['invoiceForm']->setId($id);
	}

	public function handleDeleteInvoice($id)
	{
		$invoice = $this->invoiceModel->find($id);
		$this->invoiceModel->delete($invoice);
		$this->redirect('this');
	}
}