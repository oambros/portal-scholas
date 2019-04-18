<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 04.02.2018
 * Time: 1:04
 */

namespace App\Component\Gdpr\Form;

interface IGdprOouTypeFormFactory
{
	/**
	 * @return GdprOouTypeFormControl
	 */
	function create();
}