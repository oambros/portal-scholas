<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:29
 */

namespace App\Component\Accounter\Form;

/**
 * Interface IMainSubjectFormFactory
 * @package App\Component\Accounter\Form
 */
interface IMainSubjectFormFactory
{
	/**
	 * @return MainSubjectFormControl
	 */
	function create();
}