<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.01.2018
 * Time: 22:38
 */

namespace App\Component\Invoices\Form;


interface IInvoiceFormFactory
{
	/**
	 * @return InvoiceFormControl
	 */
	function create();
}