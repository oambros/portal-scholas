<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 28.12.2018
 * Time: 19:27
 */

namespace App\Model;

use App\Model\Entity\Financing;
use Doctrine\ORM\EntityRepository;

class FinancingModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\Financing';

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
	 * @param Financing $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function save( Financing $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param Financing $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( Financing $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}


	/**
	 * @param Financing|null $ExtraPayType
	 * @return array|bool
	 */
	protected function arrayMapper( Financing $Financing = null ) {
		if(!$Financing)
			return false;

		$array_entity = array();
		$array_entity['name'] = $Financing->name;
		$array_entity['note'] = $Financing->note;

		return $array_entity;
	}

}