<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usergroup
 *
 * @ORM\Table(name="usergroups")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsergroupRepository")
 */
class Usergroup
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="usergroups")
     */
    private $users;

    /**
     * Usergroup constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Usergroup
     */
    public function setTitle(string $title): Usergroup
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     *
     * @return Usergroup
     */
    public function addUser(User $user): Usergroup
    {
        if (!$this->users->contains($user)) {
            $user->addUsergroup($this);
            $this->users->add($user);
        }
        
        return $this;
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user): void
    {
        $user->removeUsergroup($this);
        $this->users->removeElement($user);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
