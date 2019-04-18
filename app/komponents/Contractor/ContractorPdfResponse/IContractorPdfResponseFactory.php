<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 24.11.2018
 * Time: 20:01
 */

namespace App\Component\Contractor;

/**
 * Interface IContractorPdfResponseFactory
 * @package App\Component\Contractor
 */
interface IContractorPdfResponseFactory
{
	/**
	 * @return ContractorPdfResponseControl
	 */
	function create();
}