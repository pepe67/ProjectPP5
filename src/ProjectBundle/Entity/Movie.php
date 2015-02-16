<?php
namespace ProjectBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Movie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ProjectBundle\Entity\MovieRepository")
 */
class Movie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	 
	 /**
      * @ORM\ManyToOne(targetEntity="Category", inversedBy="movies")
      * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
      */
    private $category;
	/**
      * @ORM\OneToMany(targetEntity="Comment", mappedBy="movie")
      */
	protected $comments;
	
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
	
	    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    /**
     * @var string
     *
     * @ORM\Column(name="aboutmovie", type="text")
     */
    private $aboutmovie;
	
	 /**
     * @var string
     *
     * @ORM\Column(name="review", type="text")
     */
    private $review;
    /**
     * @var string
     *
     * @ORM\Column(name="posterURL", type="string", length=255)
     */
    private $posterURL;
	
	/**
     *
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;
	 /**
     * @var \DateTime
     *
     * @ORM\Column(name="released", type="datetime")
     */
    private $released;
	
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
	
	 /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Movie
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }
    
    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    /**
     * Set title
     *
     * @param string $title
     * @return Movie
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
     * Set slug
     *
     * @param string $title
     * @return Movie
     */
    public function setSlug($slug)
    {
		//Get Movie Title
		$title = $this->getTitle();
		//Char for spacing words
		$char = "-";
		// Get movie ID for slug
		$id = $this->getId();
		
		// Lower case the string and remove whitespace from the beginning or end
       $str = trim(strtolower($title));
       // Remove single quotes from the string
       $str = str_replace("‘", '', $str);
       // Every character other than a-z, 0-9 will be replaced with a single dash (-)
       $str = preg_replace("/[^a-z0-9]+/", $char, $str);
       // Remove any beginning or trailing dashes
       $str = trim($str, $char);
		
		//Slug build by replaced and stripped words and movie id
        $this->slug = $str."-".$id;
        return $this;
    }
    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Set aboutmovie
     *
     * @param string $aboutmovie
     * @return Movie
     */
    public function setAboutmovie($aboutmovie)
    {
        $this->aboutmovie = $aboutmovie;
        return $this;
    }
    /**
     * Get aboutmovie
     *
     * @return string 
     */
    public function getAboutmovie()
    {
        return $this->aboutmovie;
    }
    /**
     * Set review
     *
     * @param string $review
     * @return Movie
     */
    public function setReview($review)
    {
        $this->review = $review;
        return $this;
    }
    /**
     * Get review
     *
     * @return string 
     */
    public function getReview()
    {
        return $this->review;
    }
    /**
     * Set posterURL
     *
     * @param string $posterURL
     * @return Movie
     */
    public function setPosterURL($posterURL)
    {
        $this->posterURL = $posterURL;
        return $this;
    }
    /**
     * Get posterURL
     *
     * @return string 
     */
    public function getPosterURL()
    {
        return $this->posterURL;
    }
    /**
     * Set released
     *
     * @param \DateTime $released
     * @return Movie
     */
    public function setReleased($released)
    {
        $this->released = $released;
        return $this;
    }
    /**
     * Get released
     *
     * @return \DateTime 
     */
    public function getReleased()
    {
        return $this->released;
    }
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Movie
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Set category
     *
     * @param \ProjectBundle\Entity\Category $category
     * @return Movie
     */
    public function setCategory(\ProjectBundle\Entity\Category $category = null)
    {
        $this->category = $category;
        return $this;
    }
    /**
     * Get category
     *
     * @return \ProjectBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Set price
     *
     * @param string $price
     * @return Movie
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }
	
	public function __toString()
	{
		return $this->getPosterURL();
	}
	
	public function __toStringTitle()
	{
		return $this->getTitle();
	}
	
}