<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:29
 */

namespace App\Component\Accounter\Form;

/**
 * Interface IMonthSetHollidayFormFactory
 * @package App\Component\Accounter\Form
 */
interface IMonthSetHollidayFormFactory
{
	/**
	 * @return MonthSetHollidayFormControl
	 */
	function create();
}