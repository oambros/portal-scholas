<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 12:01
 */

namespace App\Component\Shop\Form;


interface IShopFormFactory
{
	/**
	 * @return ShopFormControl
	 */
	function create();
}