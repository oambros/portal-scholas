<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 08.11.2018
 * Time: 23:16
 */

namespace App\Model;


use App\Model\Entity\ClientUser;

class ClientUserModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\ClientUser';

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
	 * @param $email
	 * @return null|object
	 */
	public function findByLogin( $login)
	{
		return $this->getR()->findOneBy(array('login' => $login));
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
	 * @param ClientUser $entity
	 * @return mixed
	 */
	public function save( ClientUser $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param ClientUser $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( ClientUser $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param int $length
	 * @return string
	 */
	protected function getUniqueLogin( $length = 6 )
	{
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;

	}

	/**
	 * @param $login string
	 * @return bool
	 */
	public function testUniqueLogin( $login, $client_user_id = null )
	{
		$entity = $this->getR()->findBy(array('login' => (string)$login), array('id' => 'ASC'));

		if( $client_user_id ) {
			if( count($entity) > 0 && $entity[0]->getId() != $client_user_id )
				return false;
			return true;
		}
		else {
			if( count($entity) > 0 )
				return false;
			return true;
		}


	}

	/**
	 * @return bool | string
	 */
	public function createUserLogin()
	{
		for ($i = 1; $i <= 5; $i++) {
			$string = $this->getUniqueLogin();

			if( $this->testUniqueLogin($string) )
				return $string;
		}
		return false;
	}

	/**
	 * @param ClientUser $users
	 * @return array
	 */
	protected function arrayMapper( ClientUser $users = null ) {
		if(!$users)
			return false;

		$array_entity = array();

		$array_entity['login'] = $users->getLogin();
		$array_entity['email'] = $users->getEmail();
		$array_entity['active'] = $users->getActive();

		return $array_entity;
	}

}