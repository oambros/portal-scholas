<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace App\Model;


use App\Model\Entity\PayMonth;
use Doctrine\ORM\EntityRepository;

class PayMonthModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\PayMonth';

	/**
	 * @return EntityRepository
	 */
	protected function getR()
	{
		return $this->entityManager->getRepository( $this->entity );
	}

	/**
	 * @param $id
	 * @return null|object
	 */
	public function find( $id, $array = false )
	{
		$entity =  $this->getR()->find($id);
		if( $array ) {
			return $this->arrayMapper( $entity );
		}
		else {
			return $entity;
		}

	}

	/**
	 * @param bool $by
	 * @return array
	 */
	public function getList( $by = false )
	{
		return $this->getR()->findBy(array(), array('id' => 'ASC'));
	}

	/**
	 * @param PayMonth $entity
	 * @return mixed
	 */
	public function save( PayMonth $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param PayMonth $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( PayMonth $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param PayMonth $subject
	 * @return array
	 */
	protected function arrayMapper( PayMonth $PayMonth = null ) {
		if(!$PayMonth)
			return false;

		$array_entity = array();
		$array_entity['name'] = $PayMonth->name;
		$array_entity['num_free_days'] = $PayMonth->num_free_days;
		$array_entity['num_free_days_np'] = $PayMonth->num_free_days_np;
		$array_entity['note'] = $PayMonth->note;
		$array_entity['num_extra_days'] = $PayMonth->num_extra_days;

		return $array_entity;
	}

}