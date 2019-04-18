<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 21.11.2018
 * Time: 10:12
 */

namespace App\Model\Entity;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Log
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="logs")
 */
class Log
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();

	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $akce;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="MainSubject", inversedBy="logs")
     * @ORM\JoinColumn(name="main_subject_id", referencedColumnName="id")
     */
	protected $main_subject;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $user;

	/**
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="create")
	 */
	protected $create_date;

}