<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 05.11.2018
 * Time: 12:52
 */

namespace App\Component\Helpers;


class CommitmentFilter
{
	public static function filter( $commitment_id )
	{
		if( $commitment_id == 1 )
			return "Řádná dovolená";

		if( $commitment_id == 2 )
			return "Neplacené volno";

		if( $commitment_id == 3 )
			return "Nemocenská";

		return "nezmama dovolena";
	}
}