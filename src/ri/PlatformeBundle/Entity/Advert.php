<?php

namespace ri\PlatformeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;



/**
 * Application
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="ri\PlatformeBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()

 */
class Advert
{
    /**
    * @ORM\OneToMany(targetEntity="ri\PlatformeBundle\Entity\Application",mappedBy="advert")
    */
     private $applications;

    /**
    * @ORM\ManyToMany(targetEntity="ri\PlatformeBundle\Entity\Category",cascade={"persist"})
    */
    private $categories;

  // Comme la propriété $categories doit être un ArrayCollection,
  // On doit la définir dans un constructeur :
  public function __construct()
  {
    $this->date = new \Datetime();
    $this->categories = new ArrayCollection();
  }

  // Notez le singulier, on ajoute une seule catégorie à la fois
  public function addCategory(Category $category)
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau
    $this->categories[] = $category;

    return $this;
  }

  public function removeCategory(Category $category)
  {
    // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
    $this->categories->removeElement($category);
  }



    /**
   * @ORM\OneToOne(targetEntity="ri\PlatformeBundle\Entity\Image", cascade={"persist","remove"})
   */
  private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
    /**
     *
     *@ORM\Column(name="published",type="boolean")
     */
    private $published=true;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

 
    /**
     * Get image
     *
     * @return \ri\PlatformeBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

     /**
     * Get Category
     *
     * @return \ri\PlatformeBundle\Entity\Category
     */
    public function getCategories()
    {
        return $this->categories;
    }


    /**
     * Set image
     *
     * @param \ri\PlatformeBundle\Entity\image $image
     *
     * @return Advert
     */
    public function setImage(\ri\PlatformeBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Add application++
     *
     * @param \ri\PlatformeBundle\Entity\Application $application
     *
     * @return Advert
     */
    public function addApplication(\ri\PlatformeBundle\Entity\Application $application)
    {
        $this->applications[] = $application;
         $application->setAdvert($this);
        return $this;
    }

    /**
     * Remove application
     *
     * @param \ri\PlatformeBundle\Entity\Application $application
     */
    public function removeApplication(\ri\PlatformeBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
 */
private $updatedAt;

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Advert
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
    * @ORM\PreUpdate
    */
    public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }

    /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
  private $nbApplications = 0;

  public function increaseApplication()
  {
    $this->nbApplications++;
  }

  public function decreaseApplication()
  {
    $this->nbApplications--;
  }



    /**
     * Set nbApplications
     *
     * @param integer $nbApplications
     *
     * @return Advert
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;

        return $this;
    }

    /**
     * Get nbApplications
     *
     * @return integer
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }
}
