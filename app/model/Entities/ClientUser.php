<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection,
	Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 *
 * @ORM\Entity()
 * @package App\Model\Entity
 * @ORM\Table(name="client_users")
 */
class ClientUser {

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
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $email;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $login;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $pass;

	/**
	 * @ORM\Column(type="boolean", nullable=true, options={"default" : true})
	 */
	protected $active;

	/**
	 * @ORM\ManyToOne(targetEntity="MainSubject", inversedBy="client_users")
	 * @ORM\JoinColumn(name="main_subject_id", referencedColumnName="id")
	 */
	protected $main_subject;

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