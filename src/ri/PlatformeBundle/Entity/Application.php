<?php

namespace ri\PlatformeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="ri\PlatformeBundle\Repository\ApplicationRepository")
  * @ORM\HasLifecycleCallbacks()

 */
class Application
{
	
	/**
	 * @ORM\ManyToOne(targetEntity="ri\PlatformeBundle\Entity\Advert", inversedBy="applications")
	 *@ORM\JoinColumn(nullable=false)
	 */

	private $advert;


	/**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
private $id;

 /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
private $author;

/**
   *
   * @ORM\column(name="content", type="text")
   */
private $content;

 /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
private $date;



  public function __construct()

  {
    $this->date = new \Datetime();
  }

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param string $author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
	}

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param mixed $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * @return datetime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param datetime $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}


/**
	 * @return mixed
	 */
	public function getAdvert()
	{
		return $this->advert;
	}

	/**
	 * @param mixed $advert
	 */
	public function setAdvert($advert)
	{
		$this->advert = $advert;
	}


  /**
   * @ORM\PrePersist
   */
  public function increase()
  {
    $this->getAdvert()->increaseApplication();
  }

  /**
   * @ORM\PreRemove
   */
  public function decrease()
  {
    $this->getAdvert()->decreaseApplication();
  }




}
