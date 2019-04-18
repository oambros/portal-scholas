<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.12.2018
 * Time: 10:47
 */

namespace App\Component\Accounter\Form;


use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class CsvUploadControl extends Control
{

	protected  $csv = null;
	protected $header = null;

	public function createComponentForm()
	{
		$form = new Form();

		$form->addUpload('csv', 'csv');

		$form->addSubmit('submit');

		$form->onSuccess[] = array($this, 'formSuccess');

		return $form;
	}

	protected function csvParse( $file )
	{

		$file = array_map('str_getcsv', file($file));

		$head = array();

		$final_array = array(

		);

		$i = 0;

		foreach ( $file as $row ) {
			if( $i == 0 ) {
				$j = 0;
				$jump_over = 0;
				foreach ( $row as $item ) {
					if( strpos( $item, '*f' ) !== true || strpos( $item, ";'" ) !== true ) {
						$jump_over++;
						continue;
					}
					else {
						$head[] = preg_replace( '/[^a-z -]+/', '' ,$item);
					}

					$j++;
				}
			}
			else{
				$j = 0;
				foreach ( $row as $item ) {
					$final_array[$i][$head[$j]] = $item;
					$j++;
				}

			}
			$i++;
		}

		$this->csv = $final_array;
		$this->header = $head;
	}

	public function formSuccess(Form $form)
	{
		$data = $form->getValues();

		$csv = $data['csv'];

		$this->csvParse($csv);

	}

	public function render()
	{
		$template = $this->createTemplate();
		$template->header = $this->header;
		$template->items = $this->csv;
		$template->setFile(__DIR__.'/template.latte');
		$template->render();
	}

}