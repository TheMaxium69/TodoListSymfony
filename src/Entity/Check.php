<?php

namespace App\Entity;

use App\Repository\CheckRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CheckRepository::class)
 * @ORM\Table(name="`check`")
 */
class Check
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=todo::class, inversedBy="checked", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $todo;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="checks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTodo(): ?todo
    {
        return $this->todo;
    }

    public function setTodo(todo $todo): self
    {
        $this->todo = $todo;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

}
