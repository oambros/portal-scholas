<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 13:21
 */

namespace App\Model;


use App\Model\Entity\TextCategories;

class TextCategoriesModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\TextCategories';

	/**
	 * @return EntityRepository
	 */
	protected function getR()
	{
		return $this->entityManager->getRepository($this->entity);
	}

	/**
	 * @param $id
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
	public function getList($by = false)
	{
		return $this->getR()->findBy(array(), array('id' => 'ASC'));
	}

	/**
	 * @param TextCategories $entity
	 * @return mixed
	 */
	public function save(TextCategories $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param TextCategories $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(TextCategories $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	public function getSelectList($default_string = 'Vyber kategorii')
	{
		$array = array();
		$array[0] = $default_string;
		$categories = $this->getList();

		foreach ($categories  as $category) {
			$array[$category->id] = $category->name;
		}
		return $array;
	}

	/**
	 * @param TextCategories $textCategories
	 * @return array
	 */
	protected function arrayMapper(TextCategories $textCategories = null)
	{
		if (!$textCategories)
			return false;

		$array_entity = array();
		$array_entity['name'] = $textCategories->name;
		$array_entity['note'] = $textCategories->note;
		$array_entity['create_date'] = $textCategories->create_date;
		$array_entity['update_date'] = $textCategories->update_date;

		return $array_entity;
	}
}