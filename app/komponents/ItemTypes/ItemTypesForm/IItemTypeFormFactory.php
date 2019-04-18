<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16.01.2018
 * Time: 13:08
 */

namespace App\Component\ItemTypes\Form;


interface IItemTypeFormFactory
{
	/**
	 * @return ItemTypeFormControl
	 */
	function create();
}