<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 24.10.2018
 * Time: 12:29
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class Section
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="sections_allowed")
 */
class SectionAllowed
{
	use MagicAccessors;

	public function __construct()
	{
		$this->users = new ArrayCollection();
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
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $presenter_name;

	/**
	 * @ORM\ManyToMany(targetEntity="Users")
	 * @ORM\JoinTable(name="user_section_access", joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	 * inverseJoinColumns={@ORM\JoinColumn(name="section_allowed_id", referencedColumnName="id")})
	 */
	protected $users;

	/**
	 * @ORM\Column(type="text"), nullable=false)
	 */
	protected $note;
}