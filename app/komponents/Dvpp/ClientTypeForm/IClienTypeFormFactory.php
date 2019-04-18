<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:29
 */

namespace App\Component\Gdpr\Form;

/**
 * Interface IClientTypeFormFactory
 * @package App\Component\Gdpr\Form
 */
interface IClientTypeFormFactory
{
	/**
	 * @return ClientTypeFormControl
	 */
	function create();
}