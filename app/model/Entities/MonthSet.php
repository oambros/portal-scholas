<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 26.07.2018
 * Time: 11:56
 */

namespace App\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class Team
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="month_set")
 */
class MonthSet
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->hollidays = new ArrayCollection();
		$this->study_hollidays = new ArrayCollection();
		$this->doctor_hollidays = new ArrayCollection();
		$this->bonuses = new ArrayCollection();

	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $locked;

	/**
	 * @ORM\ManyToOne(targetEntity="MainSubject", inversedBy="month_sets")
	 * @ORM\JoinColumn(name="main_subject_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $main_subject;

	/**
	 * @ORM\Column(type="date", nullable=false)
	 */
	protected $month;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $note;

	/**
	 * @ORM\OneToMany(targetEntity="MonthSetHolliday", mappedBy="mset")
	 */
	protected $hollidays;

	/**
	 * @ORM\OneToMany(targetEntity="MonthSetStudyHolliday", mappedBy="mset")
	 */
	protected $study_hollidays;

	/**
	 * @ORM\OneToMany(targetEntity="MonthSetDoctorHolliday", mappedBy="mset")
	 */
	protected $doctor_hollidays;

	/**
	 * @ORM\OneToMany(targetEntity="MonthSetBonus", mappedBy="month_set")
	 */
	protected $bonuses;

	/**
	 * @ORM\OneToMany(targetEntity="ExtraPay", mappedBy="month_set")
	 */
	protected $extra_pays;

	/**
	 * @ORM\OneToMany(targetEntity="ExtraPayUniversal", mappedBy="month_set")
	 */
	protected $extra_pays_universal;

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