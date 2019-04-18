<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 26.07.2018
 * Time: 11:56
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class Team
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="employee")
 */
class Employee
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->commitments = new ArrayCollection();
		$this->extra_pays = new ArrayCollection();
	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $oscis;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $f_name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $l_name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $id_num;

	/**
	 * @ORM\Column(type="text"), nullable=false)
	 */
	protected $note;

	/**
	 * @ORM\ManyToOne(targetEntity="MainSubject", inversedBy="employees")
	 * @ORM\JoinColumn(name="main_subject_id", referencedColumnName="id")
	 */
	protected $main_subject;

	/**
	 * @ORM\OneToMany(targetEntity="Commitment", mappedBy="employee")
	 */
	protected $commitments;

	/**
	 * @ORM\OneToMany(targetEntity="MonthSetHolliday", mappedBy="employee")
	 */
	protected $month_set_hollidays;

	/**
	 * @ORM\OneToMany(targetEntity="ExtraPay", mappedBy="employee")
	 */
	protected $extra_pays;

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

	/**
	 * @return string
	 */
	public function getFullName()
	{
		return $this->f_name.' '.$this->l_name;
	}
}