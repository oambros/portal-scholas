<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:29
 */

namespace App\Component\Accounter\Form;

/**
 * Interface ISubject4UserFormFactory
 * @package App\Component\Accounter\Form
 */
interface ISubject4UserFormFactory
{
	/**
	 * @return Subject4UserFormControl
	 */
	function create();
}