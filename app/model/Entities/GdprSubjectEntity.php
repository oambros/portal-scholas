<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 21:10
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class GdprSubjectEntity
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="gdpr_subject")
 */
class GdprSubjectEntity
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255, unique=true, nullable=true)
	 */
	protected $sheet_id;

	/**
	 * @ORM\Column(type="string", length=600, unique=false, nullable=true)
	 */
	protected $note;

	/**
	 * @ORM\Column(type="string", length=255, unique=false, nullable=true)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255, unique=false, nullable=true)
	 */
	protected $street;

	/**
	 * @ORM\Column(type="string", length=255, unique=false, nullable=true)
	 */
	protected $cp;

	/**
	 * @ORM\Column(type="string", length=255, unique=false, nullable=true)
	 */
	protected $city;

	/**
	 * @ORM\Column(type="string", length=255, unique=false, nullable=true)
	 */
	protected $zip;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Model\Entity\GdprSubjectType", inversedBy="gdpr_subjects")
	 * @ORM\JoinColumn(name="gdpr_subject_type_id", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $gdpr_subject_type;

	/**
	 * @var ArrayCollection
	 * @ORM\ManyToMany(targetEntity="GdprOouType", mappedBy="gdpr_subjects")
	 */
	protected $gdpr_oou_types;

	/**
	 * @ORM\Column(type="string", length=255, unique=false, nullable=true)
	 */
	protected $lat;

	/**
	 * @ORM\Column(type="string", length=255, unique=false, nullable=true)
	 */
	protected $lng;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $sign;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $sign_date;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $audit_date;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $audit_time;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $audit_set;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $audit_price;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $flat_rate;

	/**
	 * @ORM\Column(type="smallint", nullable=true)
	 */
	protected $priority;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $subject_count;

	/**
	 * @ORM\ManyToOne(targetEntity="GdprTeam", inversedBy="gdpr_subjects")
	 * @ORM\JoinColumn(name="gdpr_team_id", referencedColumnName="id")
	 */
	protected $team;

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