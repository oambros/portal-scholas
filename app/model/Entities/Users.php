<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection,
		Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 *
 * @ORM\Entity()
 * @package App\Modsel\Entity
 * @ORM\Table(name="users")
 */
class Users {
	
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->teams = new ArrayCollection();
	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $email;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $f_name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $l_name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $phone;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $street;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $city;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $zip;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $pass;

	/**
	 * @ORM\Column(type="integer", options={"default": 2})
	 */
	protected $type;

	/**
	 * @var ArrayCollection
	 * @ORM\ManyToMany(targetEntity="GdprTeam", mappedBy="users")
	 */
	protected $teams;

	/**
	 * @var ArrayCollection
	 * @ORM\ManyToMany(targetEntity="Client", mappedBy="salesman")
	 */
	protected $clients;

	/**
	 * @var ArrayCollection
	 * @ORM\ManyToMany(targetEntity="SectionAllowed", mappedBy="users")
	 */
	protected $sections;

	/**
	 * @var ArrayCollection
	 * @ORM\ManyToMany(targetEntity="MainSubject", inversedBy="Users")
	 * @ORM\JoinTable(name="main_subject_users_assoc")
	 */
	protected $main_subjects;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="Notification", mappedBy="user")
	 */
	protected $notificatons;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $active;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $superadmin;

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

	public function clearMainSubjects() {
		$this->main_subjects->clear();
	}

}