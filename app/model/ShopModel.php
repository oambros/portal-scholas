<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 11:51
 */

namespace App\Model;

use App\Model\Entity\ShopEntity;

class ShopModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\ShopEntity';

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
	 * @param ShopEntity $entity
	 * @return mixed
	 */
	public function save( ShopEntity $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param ShopEntity $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( ShopEntity $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param ShopEntity $users
	 * @return array
	 */
	protected function arrayMapper( ShopEntity $shopEntity = null ) {
		if(!$shopEntity)
			return false;

		$array_entity = array();
		$array_entity['name'] = $shopEntity->name;
		$array_entity['url'] = $shopEntity->url;

		return $array_entity;
	}

	public function getSelectList($default_string = 'Vyber obchod')
	{
		$array = array();
		$array[0] = $default_string;
		$shops = $this->getList();

		foreach ($shops as $shop) {
			$array[$shop->id] = $shop->name;
		}
		return $array;
	}
}