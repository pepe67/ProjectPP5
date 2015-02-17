<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * MovieOrder
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MovieOrder
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
    *  @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Movie", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="movies_orders",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="cascade")}
     *      )
     **/
    private $movies;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderedAt", type="datetime")
     */
    private $orderedAt;

	/**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;
	
	/**
     * @var string
     *
     * @ORM\Column(name="valuePLN", type="string", length=255)
     */
    private $valuePLN;

    public function __construct()
    {
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
        // Ustawiamy date na aktualn¹
        $this->orderedAt = new \DateTime();
    }


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
     * Set user
     *
     * @param \stdClass $user
     * @return MovieOrder
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set movies
     *
     * @return MovieOrder
     */
    public function setMovies($movies)
    {
        $this->movies = $movies;

        return $this;
    }

    /**
     * Get movies
     *
     * @return Movies
     */
    public function getMovies()
    {
        return $this->movies;
    }
	
	/**
     * Set status
     *
     * @param string $status
     * @return MovieOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
	
    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
	
	/**
     * Set valuePLN
     *
     * @param string $valuePLN
     * @return MovieOrder
     */
    public function setValuePLN($valuePLN)
    {
        $this->valuePLN = $valuePLN;
        return $this;
    }
	
    /**
     * Get valuePLN
     *
     * @return string 
     */
    public function getValuePLN()
    {
        return $this->valuePLN;
    }
	
    /**
     * Set orderedAt
     *
     * @param \DateTime $orderedAt
     * @return OrderMovie
     */
    public function setOrderedAt($orderedAt)
    {
        $this->orderedAt = $orderedAt;

        return $this;
    }

    /**
     * Get orderedAt
     *
     * @return \DateTime 
     */
    public function getOrderedAt()
    {
        return $this->orderedAt;
    }

}
