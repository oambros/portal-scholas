<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 03.02.2018
 * Time: 23:36
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class GdprOouType
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="gdpr_oou_type")
 */
class GdprOouType
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->gdpr_subjects = new ArrayCollection();
	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255, unique=true, nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255, unique=true, nullable=true)
	 */
	protected $note;

	/**
	 * @var ArrayCollection
	 * @ORM\ManyToMany(targetEntity="GdprSubjectEntity")
	 * @ORM\JoinTable(name="subjects_oou_types",
	 *     joinColumns={@ORM\JoinColumn(name="gdpr_oou_type_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="gdpr_subject_id", referencedColumnName="id")}
	 *     )
	 */
	protected $gdpr_subjects;

	/**
	 * @ORM\Column(type="integer", options={"default: 1"},nullable=true)
	 */
	protected $position;

	/**
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="create")
	 */
	protected $create_date;

	/**
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
	 */
	protected $update_date;
}