<?php
namespace ProjectBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Comment
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
      * @ORM\ManyToOne(targetEntity="Movie", inversedBy="comments")
      * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
      */
    private $movie;
	
	
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;
    /**
     * @var boolean
     *
     * @ORM\Column(name="isAccepted", type="boolean")
     */
    private $isAccepted;
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
     * Set comment
     *
     * @param string $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }
    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * Set isAccepted
     *
     * @param boolean $isAccepted
     * @return Comment
     */
    public function setIsAccepted($isAccepted)
    {
        $this->isAccepted = $isAccepted;
        return $this;
    }
    /**
     * Get isAccepted
     *
     * @return boolean 
     */
    public function getIsAccepted()
    {
        return $this->isAccepted;
    }
    /**
     * Set movie
     *
     * @param \ProjectBundle\Entity\Movie $movie
     * @return Comment
     */
    public function setMovie(\ProjectBundle\Entity\Movie $movie = null)
    {
        $this->movie = $movie;
        return $this;
    }
    /**
     * Get movie
     *
     * @return \ProjectBundle\Entity\Movie 
     */
    public function getMovie()
    {
        return $this->movie;
    }
}