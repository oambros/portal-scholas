<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 24.11.2018
 * Time: 19:51
 */

namespace App\Component\Contractor;


use Joseki\Application\Responses\PdfResponse;
use Nette\Application\UI\Control;

class ContractorPdfResponseControl extends Control
{


	public function __construct()
	{
		
	}
	
	public function actionRender()
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/template.latte');

		$pdf = new PdfResponse($template);
		$pdf->setSaveMode(PdfResponse::DOWNLOAD);

		$this->presenter->sendResponse($pdf);
	}
}