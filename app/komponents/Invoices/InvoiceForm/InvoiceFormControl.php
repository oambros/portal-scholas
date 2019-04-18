<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.01.2018
 * Time: 22:17
 */

namespace App\Component\Invoices\Form;


use App\Model\Entity\InvoiceEntity;
use App\Model\InventoryItemsModel;
use App\Model\InvoiceModel;
use Nette\Application\Responses\FileResponse;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class InvoiceFormControl extends Control
{
	protected $id;

	/**
	 * @var InvoiceModel
	 */
	protected $invoiceModel;

	/**
	 * @var InventoryItemsModel
	 */
	protected $inventoryItemModel;

	protected $upload_path = '/uploads/invoices/';

	/**
	 * InvoiceFormControl constructor.
	 * @param InvoiceModel $invoiceModel
	 */
	public function __construct(InvoiceModel $invoiceModel, InventoryItemsModel $inventoryItemsModel)
	{
		$this->invoiceModel = $invoiceModel;
		$this->inventoryItemModel = $inventoryItemsModel;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$form->addText('number', 'Číslo faktury:');
		$form->addUpload('file', 'Soubor');
		$form->addTextArea('note', 'Popis');
		$form->addMultiSelect('inventory_items', 'Položky', $this->inventoryItemModel->getSelectList());

		if( $this->id ) {
			$form->setDefaults($this->invoiceModel->find($this->id, true));
		}

		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = array($this, 'onSubmit');

		return $form;
	}

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
	}

	/**
	 * @param Form $form
	 * @throws \Nette\Application\AbortException
	 */
	public function onSubmit( Form $form )
	{
		$data = $form->getValues();

		if($this->id) {
			$invoice = $this->invoiceModel->find($this->id);
		}
		else {
			$invoice = new InvoiceEntity();
		}

		if($data->file->isOk()) {
			$file_ext=strtolower(mb_substr($data->file->getSanitizedName(), strrpos($data->file->getSanitizedName(), ".")));
			$file_name = uniqid(rand(0,20), TRUE).$file_ext;

			$data->file->move($_SERVER['DOCUMENT_ROOT'].$this->upload_path.$file_name);
			$invoice->setFile( $file_name );
		}

		$invoice->setNumber( $data->number );
		$invoice->setNote( $data->note );


		if($this->invoiceModel->save( $invoice )) {
			$this->presenter->flashMessage('Upraveno');
		}

		$this->presenter->redirect('Invoice:default');

	}

	public function handleDownload( ) {
		if( $this->id ) {
			$invoice = $this->invoiceModel->find($this->id);
			if( $invoice->file ) {
				$this->presenter->sendResponse( new FileResponse( $_SERVER['DOCUMENT_ROOT'].$this->upload_path.$invoice->file ) );

			}
		}


	}

	public function handleDeleteFile( ) {
		if( $this->id ) {
			$invoice = $this->invoiceModel->find($this->id);
			if( $invoice->file ) {
				unlink($_SERVER['DOCUMENT_ROOT'].$this->upload_path.$invoice->file);
				$invoice->setFile(null);
				$this->invoiceModel->save($invoice);

			}
			$this->redirect('this');
		}


	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/form.latte');
		$template->upload_path = $_SERVER['DOCUMENT_ROOT'].$this->upload_path;
		if( $this->id )
			$template->invoice = $this->invoiceModel->find($this->id);

		$template->render();
	}

}