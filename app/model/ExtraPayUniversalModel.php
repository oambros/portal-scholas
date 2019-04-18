<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 27.12.2018
 * Time: 14:28
 */

namespace App\Model;

use App\Model\Entity\ExtraPayUniversal;
use Doctrine\ORM\EntityRepository;

class ExtraPayUniversalModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\ExtraPayUniversal';

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
	 * @param ExtraPayUniversal $entity
	 * @return mixed
	 */
	public function save( ExtraPayUniversal $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param ExtraPayUniversal $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( ExtraPayUniversal $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param ExtraPayUniversal $subject
	 * @return array
	 */
	protected function arrayMapper( ExtraPayUniversal $ExtraPay = null ) {
		if(!$ExtraPay)
			return false;

		$array_entity = array();
		$array_entity['name'] = $ExtraPay->name;
		$array_entity['amount'] = $ExtraPay->amount;
		$array_entity['hours'] = $ExtraPay->hours;
		$array_entity['type_id'] = $ExtraPay->type_id;
		$array_entity['note'] = $ExtraPay->note;

		return $array_entity;
	}
}