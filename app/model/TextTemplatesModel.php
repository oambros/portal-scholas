<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.02.2018
 * Time: 17:39
 */

namespace App\Model;


use App\Model\Entity\TextTemplate;

class TextTemplatesModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\TextTemplate';
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
	public function getList($by = array())
	{
		return $this->getR()->findBy($by, array('id' => 'ASC'));
	}

	/**
	 * @param TextTemplate $entity
	 * @return mixed
	 */
	public function save(TextTemplate $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param TextTemplate $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(TextTemplate $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param Texts $texts
	 * @return array
	 */
	protected function arrayMapper(TextTemplate $template = null)
	{
		if (!$template)
			return false;

		$array_entity = array();
		$array_entity['name'] = $template->name;
		$array_entity['text'] = $template->text;
		$array_entity['create_date'] = $template->create_date;
		$array_entity['update_date'] = $template->update_date;

		return $array_entity;
	}
}