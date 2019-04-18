<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace App\Model;


use App\Model\Entity\Users;
use Doctrine\ORM\EntityRepository;

class UsersModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\Users';

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
	 * @param $email
	 * @return null|object
	 */
	public function findByEmail( $email )
	{
		return $this->getR()->findOneBy(array('email' => $email));
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
	 * @param Users $entity
	 * @return mixed
	 */
	public function save( Users $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param Users $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( Users $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param Users $users
	 * @return array
	 */
	protected function arrayMapper( Users $users = null ) {
		if(!$users)
			return false;

		$array_entity = array();
		$array_entity['email'] = $users->email;
		$array_entity['f_name'] = $users->f_name;
		$array_entity['l_name'] = $users->l_name;
		$array_entity['street'] = $users->street;
		$array_entity['city'] = $users->city;
		$array_entity['zip'] = $users->zip;
		$array_entity['phone'] = $users->phone;
		$array_entity['type'] = $users->type;
		$array_entity['active'] = $users->active;
		$array_entity['superadmin'] = $users->superadmin;

		return $array_entity;
	}

	public function getCheckboxList()
	{
		$array = array();
		$users = $this->getList();

		foreach ($users as $user) {
			$array[$user->id] = $user->f_name.' '.$user->l_name;
		}
		return $array;
	}

	/**
	 * @param Users $users
	 * @return Users
	 */
	public function clearMainSubjects( Users $users )
	{
		//$this->entityManager->persist($users);
		$subjects = $users->getMain_subjects();

		foreach ($subjects as $subject) {
			$users->main_subjects->remove($subject->getId());
		}

		return $users;
	}
}