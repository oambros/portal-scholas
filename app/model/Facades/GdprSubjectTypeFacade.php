<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 05.02.2018
 * Time: 10:14
 */

namespace App\Component\Gdpr\Form;


use App\Model\GdprOouTypeModel;
use App\Model\GdprSubjectModel;

class GdprSubjectTypeFacade
{
	/**
	 * @var GdprSubjectModel
	 */
	protected $gdprSubjectModel;

	/**
	 * @var GdprOouTypeModel
	 */
	protected $gdprSubjectTypeModel;

	/**
	 * @var GdprOouTypeModel
	 */
	protected $gdprOouTypeModel;

	/**
	 * GdprSubjectTypeFacade constructor.
	 * @param GdprSubjectModel $gdprSubjectModel
	 * @param GdprOouTypeModel $gdprSubjectTypeModel
	 * @param GdprOouTypeModel $gdprOouTypeModel
	 */
	public function __construct(GdprSubjectModel $gdprSubjectModel, GdprOouTypeModel $gdprSubjectTypeModel, GdprOouTypeModel $gdprOouTypeModel)
	{
		$this->gdprSubjectModel = $gdprSubjectModel;
		$this->gdprSubjectTypeModel = $gdprSubjectTypeModel;
		$this->gdprOouTypeModel = $gdprOouTypeModel;
	}

	public function formSave( GdprSubjectEntity $entity, $data )
	{
		(isset($data->name) ? $entity->setName($data->name) : null);
		(isset($data->note) ? $entity->setNote($data->note) : null);
		(isset($data->street) ? $entity->setStreet($data->street) : null);
		(isset($data->cp) ? $entity->setCp($data->cp) : null);
		(isset($data->city) ? $entity->setCity($data->city) : null);
		(isset($data->zip) ? $entity->setZip($data->zip) : null);
		(isset($data->zip) ? $entity->setZip($data->zip) : null);
		$entity->setUpdate_date(new DateTime('now'));

		$this->entityManager->persist($entity);

		$entity->gdpr_oou_types->clear();
		foreach ( $entity as $oou_type ) {
			$entity->Gdpr_oou_types($this->gdprOouTypeModel->find($oou_type));
		}

		return $this->entityManager->persist($entity)->flush();
	}


}