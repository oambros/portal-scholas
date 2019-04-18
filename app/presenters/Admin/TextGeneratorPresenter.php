<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 15:52
 */

namespace App\AdminModule\Presenters;


use App\Component\Texts\Generator\ITextGeneratorFactory;

class TextGeneratorPresenter extends BasePresenter
{
	/**
	 * @var ITextGeneratorFactory
	 * @inject
	 */
	public $textGenetratorFactory;

	/**
	 * @return \App\Component\Texts\Generator\TextGeneratorControl
	 */
	public function createComponentTextGenerator()
	{
		return $this->textGenetratorFactory->create();
	}
	
	public function actionDefault( $id = null )
	{
		if($id) {
			$this['textGenerator']->setId($id);
		}
	}
}