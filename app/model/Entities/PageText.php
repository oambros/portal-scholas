<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 18.02.2018
 * Time: 10:58
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection,
	Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 *
 * Class PageText
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="page_texts")
 */

class PageText
{
	use MagicAccessors;

	/**
	 * @ORM\Column(type="string", unique=true, nullable=false)
	 * @ORM\Id
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $title;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $page_text;
}