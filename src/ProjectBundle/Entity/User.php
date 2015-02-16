<?php
// src/ProjectBundle/Entity/User.php

namespace ProjectBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Wpisz swoje imie.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Imie jest za krótkie.",
     *     maxMessage="Imie jest za długie.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $imie;
	/**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Wpisz swoje nazwisko.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Nazwisko jest za krótkie.",
     *     maxMessage="Nazwisko jest za długie.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $nazwisko;


    public function __construct()
    {
        parent::__construct();
        // your own logic
		$this->roles = array('ROLE_USER'); // Nadawanie nowym userom niskich uprawnień
    }
	
	public function getImie()
    {
        return $this->imie;
    }
	public function setImie($imie)
    {
        $this->imie = $imie;

        return $this;
    }
	public function getNazwisko()
    {
        return $this->nazwisko;
    }
	public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;

        return $this;
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
}
