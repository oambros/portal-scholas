<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 14:50
 */

namespace App\Component\Texts\Form;


interface ITextFormFactory
{
	/**
	 * @return TextFormControl
	 */
	function create();
}