<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 26.07.2018
 * Time: 11:56
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class ExtraPayType
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="extra_pay_types")
 */
class ExtraPayType
{
	use MagicAccessors;

	public function __construct() {
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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="smallint", nullable=false)
	 */
	protected $base_type;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $form_type;

	/**
	 * @ORM\Column(type="text"), nullable=false)
	 */
	protected $note;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $odmdr;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="ExtraPay", mappedBy="extra_pay_type")
	 *
	 */
	protected $extra_pays;

	/**
	 * @ORM\ManyToOne(targetEntity="MainSubjectExtraPayType", inversedBy="ept")
	 * @ORM\JoinColumn(name="subject_ept_id", referencedColumnName="id")
	 */
	protected $subject_ept;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $icon_class;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $icon_color;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $active;

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