<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 18.03.2018
 * Time: 21:29
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
 * @ORM\Table(name="gdpr_team")
 */
class GdprTeam
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->users = new ArrayCollection();
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
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $note;

	/**
	 * @ORM\Column(type="smallint", nullable=true)
	 */
	protected $type;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="Users", inversedBy="teams")
	 * @ORM\JoinTable(
	 *  name="user_gdpr_groups",
	 *  joinColumns={
	 *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 *  },
	 *  inverseJoinColumns={
	 *      @ORM\JoinColumn(name="gdprteam_id", referencedColumnName="id")
	 *  }
	 * )
	 */
	protected $users;

	/**
	 * @var ArrayCollection
	 *@ORM\OneToMany(targetEntity="GdprSubjectEntity", mappedBy="team")
	 */
	protected $gdpr_subjects;

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
	 * @param Users $user
	 */
	public function addUser( Users $user )
	{
		$this->users[] = $user;
	}

	public function clearUsers()
	{
		$this->users->clear();
	}

}