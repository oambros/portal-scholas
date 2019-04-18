<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace App\Model;


use App\Model\Entity\Employee;
use Doctrine\ORM\EntityRepository;

class EmployeeModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\Employee';

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
	 * @param $main_subject_id
	 * @return array
	 */
	public function getListByMainSubject( $main_subject_id, $select_type = false )
	{
		$employees = $this->getR()->findBy(array('main_subject' => $main_subject_id), array('id' => 'ASC'));
		if( $select_type ) {
			$select_array = array();
			foreach ( $employees as $employee ) {
				$select_array[$employee->id] = $employee->getF_name().' '.$employee->getL_name();
			}
			return $select_array;
		}
		else
			return $employees;

	}

	/**
	 * @param Employee $entity
	 * @return mixed
	 */
	public function save( Employee $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param Employee $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( Employee $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param Employee $subject
	 * @return array
	 */
	protected function arrayMapper( Employee $employee = null ) {
		if(!$employee)
			return false;

		$array_entity = array();
		$array_entity['oscis'] = $employee->getOscis();
		$array_entity['f_name'] = $employee->getF_name();
		$array_entity['l_name'] = $employee->getL_name();
		$array_entity['id_num'] = $employee->getId_num();
		$array_entity['note'] = $employee->getNote();
		$array_entity['main_subject'] = $employee->getMain_subject();
		return $array_entity;
	}

}