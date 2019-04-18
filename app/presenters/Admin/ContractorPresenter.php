<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 24.11.2018
 * Time: 19:54
 */

namespace App\AdminModule\Presenters;


use App\Component\Contractor\IContractorPdfResponseFactory;
use Joseki\Application\Responses\PdfResponse;
use Latte\Engine;

class ContractorPresenter extends BasePresenter
{

	/**
	 * @var IContractorPdfResponseFactory
	 * @inject
	 */
	public $contractor;

	public function createComponentContractor()
	{
		$this->contractor->create();
	}

	public function actionDefault() {

		$latte = new Engine();
		$latte->setTempDirectory(__DIR__.'/../../../temp/pdf/');

		$template = $latte->renderToString(__DIR__ . '/templates/Contractor/template.latte');

		$pdf = new PdfResponse($template);
		$this->sendResponse($pdf);

	}
}