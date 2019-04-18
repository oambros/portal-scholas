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
 * Class MainSubjectExtraPayType
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="main_subject_extra_pay_types")
 */
class MainSubjectExtraPayType
{
	use MagicAccessors;

	public function __construct() {
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->ept = new ArrayCollection();
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
	 * @ORM\Column(type="text"), nullable=false)
	 */
	protected $note;

	/**
	 * @ORM\OneToMany(targetEntity="ExtraPayType", mappedBy="subject_ept")
	 *
	 */
	protected $ept;

	/**
	 * @ORM\OneToMany(targetEntity="MainSubject", mappedBy="main_subject_extra_pay_type")
	 *
	 */
	protected $main_subjects;

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

	public function clearEpt() {
		foreach ($this->ept as $ept) {
			$ept->setSubject_ept(null);
		}
		return $this;
	}

	/**
	 * @param ExtraPayType $extraPayType
	 * @return $this
	 */
	public function addEpt( ExtraPayType $extraPayType )
	{
		$this->ept->add($extraPayType);
		$extraPayType->setSubject_ept($this);
		return $this;
	}
}