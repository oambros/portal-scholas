<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 18.02.2018
 * Time: 11:25
 */

namespace App\AdminModule\Presenters;


class PageTextPresenter extends BasePresenter
{
	public function actionDefault()
	{
		$this->template->pageTexts = $this->pageTextModel->getList();
	}

	public function handleChangeTitleText() {
		$id = $this->request->getPost('id');
		$title = $this->request->getPost('title');

		$pageText = $this->pageTextModel->find($id);
		$pageText->setTitle($title);
		$this->pageTextModel->save($pageText);
		$this->payload->response = 'ok';
		$this->sendPayload();
	}
}