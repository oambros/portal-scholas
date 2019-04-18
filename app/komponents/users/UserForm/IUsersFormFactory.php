<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 10:29
 */

namespace App\Component\Users\Forms;


interface IUsersFormFactory
{
	/**
	 * @return UsersFormControl
	 */
	function create();
}