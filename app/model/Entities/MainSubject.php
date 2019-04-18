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
 * @ORM\Table(name="main_subject")
 */
class MainSubject
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->employees = new ArrayCollection();
		$this->month_sets = new ArrayCollection();
		$this->client_users = new ArrayCollection();
		$this->financings = new ArrayCollection();
		$this->logs = new ArrayCollection();
	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $v_id;

	/**
	 * @ORM\Column(type="string", length=255, unique=true, nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $street;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $cp;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $town;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $zip;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $ico;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $dic;

	/**
	 * @ORM\Column(type="text"), nullable=false)
	 */
	protected $note;

	/**
	 * @ORM\ManyToOne(targetEntity="ClientType", inversedBy="clients")
	 * @ORM\JoinColumn(name="client_type_id", referencedColumnName="id")
	 */
	protected $type;


	/**
	 * @ORM\ManyToOne(targetEntity="MainSubjectExtraPayType", inversedBy="main_subjects")
	 * @ORM\JoinColumn(name="main_subject_extra_pay_type_id", referencedColumnName="id")
	 */
	protected $main_subject_extra_pay_type;

	/**
	 * @ORM\OneToMany(targetEntity="Employee", mappedBy="main_subject")
	 */
	protected $employees;

	/**
	 * @ORM\OneToMany(targetEntity="Financing", mappedBy="main_subject")
	 */
	protected $financings;

	/**
	 * @var ArrayCollection
	 * @ORM\ManyToMany(targetEntity="Users", mappedBy="main_subjects")
	 */
	protected $users;

	/**
	 * @ORM\OneToMany(targetEntity="MonthSet", mappedBy="main_subject")
	 */
	protected $month_sets;

	/**
	 * @ORM\OneToMany(targetEntity="ClientUser", mappedBy="main_subject")
	 */
	protected $client_users;

	/**
	 * @ORM\OneToMany(targetEntity="Contract", mappedBy="main_subject")
	 */
	protected $contracts;

    /**
     * @ORM\OneToMany(targetEntity="Log", mappedBy="main_subject")
     */
	protected $logs;

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
	 * @return array
	 */
	public function getFinancingsCheckboxList()
	{
		$array = [];
		$array[0] = 'neurčeno';
		foreach ( $this->financings as $financing )
			$array[ $financing->getId() ] = $financing->getName();
		return $array;
	}
}