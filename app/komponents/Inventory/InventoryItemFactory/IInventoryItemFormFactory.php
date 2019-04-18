<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 18.01.2018
 * Time: 0:06
 */

namespace App\Component\Inventory\Form;


interface IInventoryItemFormFactory
{
	/**
	 * @return InventoryItemFormControl
	 */
	function create();
}