<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 13.02.2019
 * Time: 14:32
 */

namespace App\Model\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Financing
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="financing")
 */
class Financing
{

	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->extra_pays = new ArrayCollection();
	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="text", length=255, nullable=true)
	 */
	protected $note;

	/**
	 * @ORM\ManyToOne(targetEntity="MainSubject", inversedBy="financings")
	 * @ORM\JoinColumn(name="main_subject_id", referencedColumnName="id")
	 */
	protected $main_subject;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="ExtraPay", mappedBy="financing")
	 */
	protected $extra_pays;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="ExtraPayUniversal", mappedBy="financing")
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