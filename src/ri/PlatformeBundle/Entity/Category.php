<?php
// src/OC/PlatformBundle/Entity/Category.php

namespace ri\PlatformeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Category
{
  /**
   * @ORM\ManyToMany(targetEntity="ri\PlatformeBundle\Entity\Advert", mappedBy="Category")
   *@ORM\JoinColumn(nullable=false)
   */

  private $advert;
 
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;

  public function getId()
  {
    return $this->id;
  }

  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  public function getName()
  {
    return $this->name;
  }
   

  /**
     * Set advert
     *
     * @param \ri\PlatformeBundle\Entity\advert $advert
     *
     * @return category
     */
    public function setAdvert(Advert $advert)
    {
        $this->advert=$advert;
        return $this;
    }

    /**
     * Get advert
     *
       * @param \ri\PlatformeBundle\Entity\advert $advert
     *
     */
    public function getAdvert()
    {
        return $this->advert;
    }
}
