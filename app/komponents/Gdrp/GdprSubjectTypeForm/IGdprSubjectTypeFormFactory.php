<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:29
 */

namespace App\Component\Gdpr\Form;

/**
 * Interface IGdprSubjectTypeFormFactory
 * @package App\Component\Gdpr\Form
 */
interface IGdprSubjectTypeFormFactory
{
	/**
	 * @return GdprSubjectTypeFormControl
	 */
	function create();
}