<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 18.02.2018
 * Time: 11:02
 */

namespace App\Model;


use App\Model\Entity\PageText;
use App\Presenters\BasePresenter;

class PageTextModel extends BaseModel {

	protected $entity = 'App\Model\Entity\PageText';

	/**
	 * @return EntityRepository
	 */
	protected function getR()
	{
		return $this->entityManager->getRepository($this->entity);
	}

	/**
	 * @param $key
	 * @return null|object
	 */
	public function find($id, $array = false)
	{
		$entity = $this->getR()->find($id);
		if ($array) {
			return $this->arrayMapper($entity);
		} else {
			return $entity;
		}
	}

	/**
	 * @param bool $by
	 * @return array
	 */
	public function getList($by = array())
	{
		return $this->getR()->findBy($by, array('id' => 'ASC'));
	}

	/**
	 * @param PageText $entity
	 * @return mixed
	 */
	public function save(PageText $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param PageText $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(PageText $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getPageText($id)
	{
		$pageText = $this->find($id);

		if(!$pageText) {
			$pageText = new PageText();
			$pageText->setId($id);
			$pageText->setTitle($id);
			$this->save($pageText);
			return $id;
		}
		else {
			return $pageText->title;
		}

	}

	/**
	 * @param PageText|null $pageText
	 * @return array|bool
	 */
	protected function arrayMapper( PageText $pageText = null)
	{
		if (!$pageText)
			return false;

		$array_entity = array();
		$array_entity['id'] = $pageText->id;
		$array_entity['title'] = $pageText->title;
		$array_entity['page_text'] = $pageText->page_text;

		return $array_entity;
	}
}