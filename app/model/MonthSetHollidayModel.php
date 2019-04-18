<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:51
 */

namespace App\Model;


use App\Model\Entity\MonthSetHolliday;

class MonthSetHollidayModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\MonthSetHolliday';

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
	 * @param MonthSetHolliday $entity
	 * @return mixed
	 */
	public function save(MonthSetHolliday $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param MonthSetHolliday $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(MonthSetHolliday $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param MonthSetHolliday|null $pageText
	 * @return array|bool
	 */
	protected function arrayMapper( MonthSetHolliday $entity = null)
	{
		if (!$entity)
			return false;

		$array_entity = array();
		$array_entity['id'] = $entity->id;
		$array_entity['start'] = $entity->start;
		$array_entity['stop'] = $entity->stop;
		$array_entity['employee'] = $entity->employee;
		$array_entity['half_day_start'] = $entity->half_day_start;
		$array_entity['half_day_stop'] = $entity->half_day_stop;

		return $array_entity;
	}
}