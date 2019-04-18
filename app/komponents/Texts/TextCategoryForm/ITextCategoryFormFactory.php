<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 13:45
 */

namespace App\Component\Texts\Form;


interface ITextCategoryFormFactory
{
	/**
	 * @return TextCategoryFormControl
	 */
	function create();
}