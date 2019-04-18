<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 28.03.2019
 * Time: 0:13
 */

namespace App\Model;

use App\Model\Entity\MonthSetDoctorHolliday;

class MonthSetDoctorHolidayModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\MonthSetDoctorHolliday';

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
	 * @param MonthSetDoctorHolliday $entity
	 * @return mixed
	 */
	public function save(MonthSetDoctorHolliday $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param MonthSetDoctorHolliday $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(MonthSetDoctorHolliday $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param MonthSetDoctorHolliday|null $pageText
	 * @return array|bool
	 */
	protected function arrayMapper( MonthSetDoctorHolliday $entity = null)
	{
		if (!$entity)
			return false;

		$array_entity = array();
		$array_entity['id'] = $entity->id;
		$array_entity['hours'] = $entity->hours;
		$array_entity['note'] = $entity->note;
		$array_entity['employee'] = $entity->employee;

		return $array_entity;
	}

}