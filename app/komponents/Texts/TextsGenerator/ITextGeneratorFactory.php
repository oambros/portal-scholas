<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 15:40
 */

namespace App\Component\Texts\Generator;


interface ITextGeneratorFactory
{
	/**
	 * @return TextGeneratorControl
	 */
	function create();
}