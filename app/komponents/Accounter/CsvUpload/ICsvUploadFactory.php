<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 22:29
 */

namespace App\Component\Accounter\Form;

/**
 * Interface ICsvUploadFactory
 * @package App\Component\Accounter\Form
 */
interface ICsvUploadFactory
{
	/**
	 * @return CsvUploadControl
	 */
	function create();
}