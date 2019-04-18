<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 24.10.2018
 * Time: 15:03
 */

namespace App\Component\Section\Forms;


interface ISectionFormFactory
{
	/**
	 * @return SectionFormControl
	 */
	function create();
}