<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:51
 */

namespace App\Model;

use App\Model\Entity\MonthSetBonus;
use App\Model\Entity\MonthSetHolliday;

class MonthSetBonusModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\MonthSetBonus';

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
	 * @param MonthSetBonus $entity
	 * @return mixed
	 */
	public function save(MonthSetBonus $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param MonthSetBonus $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(MonthSetBonus $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param MonthSetBonus|null $pageText
	 * @return array|bool
	 */
	protected function arrayMapper( MonthSetBonus $entity = null)
	{
		if (!$entity)
			return false;

		$array_entity = array();
		$array_entity['id'] = $entity->id;
		$array_entity['title'] = $entity->title;

		return $array_entity;
	}
}