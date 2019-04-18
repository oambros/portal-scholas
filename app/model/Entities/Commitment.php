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
 * @ORM\Table(name="commitment")
 */
class Commitment
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->extra_pays = new ArrayCollection();
		$this->month_set_hollidays = new ArrayCollection();
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
	protected $pracv;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $cicin;


	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $num_free_days;

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="commitments")
	 * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
	 */
	protected $employee;

	/**
	 * @ORM\OneToMany(targetEntity="MonthSetHolliday", mappedBy="commitment")
	 */
	protected $month_set_hollidays;

	/**
	 * @ORM\OneToMany(targetEntity="ExtraPay", mappedBy="commitment")
	 *
	 */
	protected $extra_pays;

	/**
	 * @ORM\Column(type="text"), nullable=false)
	 */
	protected $note;

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