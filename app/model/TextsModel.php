<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 13:29
 */

namespace App\Model;


use App\Model\Entity\Texts;

class TextsModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\Texts';

	/**
	 * @return EntityRepository
	 */
	protected function getR()
	{
		return $this->entityManager->getRepository($this->entity);
	}

	/**
	 * @param $id
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
	 * @param Texts $entity
	 * @return mixed
	 */
	public function save(Texts $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param Texts $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(Texts $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param Texts $texts
	 * @return array
	 */
	protected function arrayMapper(Texts $texts = null)
	{
		if (!$texts)
			return false;

		$array_entity = array();
		$array_entity['text'] = $texts->text;
		$array_entity['text_category'] = ($texts->text_category ? $texts->text_category->id : null);
		$array_entity['create_date'] = $texts->create_date;
		$array_entity['update_date'] = $texts->update_date;

		return $array_entity;
	}
}