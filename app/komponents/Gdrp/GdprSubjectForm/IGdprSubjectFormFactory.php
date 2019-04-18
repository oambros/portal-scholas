<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 03.02.2018
 * Time: 22:31
 */

namespace App\Component\Gdpr\Form;

interface IGdprSubjectFormFactory
{
	/**
	 * @return GdprSubjectFormControl
	 */
	function create();
}