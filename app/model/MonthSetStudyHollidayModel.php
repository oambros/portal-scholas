<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 18.12.2018
 * Time: 9:21
 */

namespace App\Model;


use App\Model\Entity\MonthSetStudyHolliday;

class MonthSetStudyHollidayModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\MonthSetStudyHolliday';

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
	 * @param MonthSetStudyHolliday $entity
	 * @return mixed
	 */
	public function save(MonthSetStudyHolliday $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param MonthSetStudyHolliday $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(MonthSetStudyHolliday $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param MonthSetStudyHolliday|null $entity
	 * @return array|bool
	 */
	protected function arrayMapper( MonthSetStudyHolliday $entity = null)
	{
		if (!$entity)
			return false;

		$array_entity = array();
		$array_entity['id'] = $entity->id;
		$array_entity['note'] = $entity->note;
		$array_entity['date_from'] = $entity->date_from;
		$array_entity['from_halfday'] = $entity->from_halfday;
		$array_entity['date_to'] = $entity->date_to;
		$array_entity['to_halfday'] = $entity->to_halfday;
		$array_entity['employee'] = $entity->employee;


		return $array_entity;
	}
}