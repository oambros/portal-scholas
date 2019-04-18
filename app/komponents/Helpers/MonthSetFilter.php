<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 08.11.2018
 * Time: 22:12
 */

namespace App\Component\Helpers;


class MonthSetFilter
{
	public static function filter( $date )
	{
		$czechMonths = array('leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec');
		return $czechMonths[$date->format('n') - 1];
	}
}