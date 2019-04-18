<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace App\Model;


use App\Model\Entity\Commitment;
use App\Model\Entity\Employee;
use Doctrine\ORM\EntityRepository;

class CommitmentModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\Commitment';

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
	 * @param $employee_id
	 * @return array
	 */
	public function getCommitmentsByEmployee( $employee_id, $select = false )
	{
		if( $select ) {
			$array = array();
			$commitments = $this->getR()->findBy(array('employee' => (int)$employee_id), array('cicin' => 'ASC'));
			foreach ( $commitments as $commitment ) {
				$array[(string)$commitment->id] = $commitment->getName();
			}

			return $array;
		}
		return $this->getR()->findBy(array('employee' => (int)$employee_id), array('cicin' => 'ASC'));

	}


	/**
	 * @param Commitment $entity
	 * @return mixed
	 */
	public function save( Commitment $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param Commitment $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( Commitment $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param Commitment $subject
	 * @return array
	 */
	protected function arrayMapper( Commitment $Commitment = null ) {
		if(!$Commitment)
			return false;

		$array_entity = array();
		$array_entity['name'] = $Commitment->name;
		$array_entity['pracv'] = $Commitment->pracv;
		$array_entity['cicin'] = $Commitment->cicin;
		$array_entity['num_free_days'] = $Commitment->num_free_days;
		$array_entity['employee'] = $Commitment->employee;
		$array_entity['note'] = $Commitment->note;

		return $array_entity;
	}

}