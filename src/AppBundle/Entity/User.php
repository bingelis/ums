<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Usergroup", inversedBy="users")
     * @ORM\JoinTable(name="users_usergroups")
     */
    private $usergroups;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->usergroups = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getUsergroups(): Collection
    {
        return $this->usergroups;
    }

    /**
     * @param Usergroup $usergroup
     * 
     * @return User
     */
    public function addUsergroup(Usergroup $usergroup): User
    {
        $this->usergroups->add($usergroup);
        
        return $this;
    }

    /**
     * @param Usergroup $usergroup
     */
    public function removeUsergroup(Usergroup $usergroup): void
    {
        $this->usergroups->removeElement($usergroup);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
