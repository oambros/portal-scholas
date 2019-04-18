<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 21.11.2018
 * Time: 10:31
 */

namespace App\Model;


use App\Model\Entity\Log;
use App\Model\Entity\MainSubject;

class LogModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\Log';


    /**
     * @return \Kdyby\Doctrine\EntityRepository
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
	public function getList( $by = array() )
	{
		return $this->getR()->findBy( $by , array('id' => 'ASC'));
	}

    /**
     * @param $main_suject_id
     * @return array
     */
    public function getListByMainSubject( $main_suject_id ) {
	    return $this->getList( array('main_subject' => (int)$main_suject_id) );
    }

    /**
     * @param Log $entity
     * @return \Kdyby\Doctrine\EntityManager
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function save( Log $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

    /**
     * @param Log $entity
     * @return \Kdyby\Doctrine\EntityManager
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function delete( Log $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param Log $subject
	 * @return array
	 */
	protected function arrayMapper( Log $log = null ) {
		if(!$log)
			return false;

		$array_entity = array();
		$array_entity['type'] = $log->type;
		$array_entity['user'] = $log->user;

		return $array_entity;
	}

	/**
	 * @param null $type
	 * @param null $user
	 * @param MainSubject $mainSubject
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
	public function createLog( $type = null, $user = null, MainSubject $mainSubject)
	{
		$log = new Log();
		$log->setType($type);
		$log->setUser($user);
		($mainSubject != null ? $log->setMain_subject($mainSubject): null );

		$this->save( $log );
	}

	/**
	 * @param $main_subject_id
	 * @return mixed
	 * @throws \Doctrine\ORM\Query\QueryException
	 */
	public function getCountLog( $main_subject_id )
	{
		$query = $this->entityManager->createQueryBuilder();
		$query->select('count(log.id)');

		$query->from( $this->entity, 'log' )
			->where('log.main_subject = :main_subject_id' )
			->setParameter('main_subject_id', (int)$main_subject_id);

		return $query->getQuery()->getSingleScalarResult();
	}

	/**
	 * @param null $action
	 * @param null $user
	 * @return array
	 */
	public function getLogByActionAndUser( $main_subject_id, $action = null, $user = null )
	{

		$query = $this->getR()->createQueryBuilder('log');
		$query->where('log.main_subject = '.(int)$main_subject_id);
		if( $action ) {
			$query->where('log.type LIKE :action');
			$query->setParameter('action', $action.'%');
		}

		if( $user ) {
			$query->where('log.user LIKE :user');
			$query->setParameter('user', $user.'%');
		}

		return $query->getQuery()->getResult();
	}
}