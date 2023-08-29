<?php

namespace App\Entity;

use DateTimeImmutable;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:project:collection']]
)]
#[Get(
    normalizationContext: ['groups' => ['read:project:collection', 'read:project:item', 'read:task:collection' ]]
)]
#[GetCollection]
#[Post]
#[Put]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:project:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:project:collection'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:project:collection'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:project:collection'])]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:project:collection'])]
    private ?\DateTimeImmutable $deadline = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'projects')]
    #[Groups(['read:project:item'])]
    private Collection $contributor;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Tasks::class)]
    #[Groups(['read:project:item'])]
    private Collection $tasks;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->contributor = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDeadline(): ?\DateTimeImmutable
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeImmutable $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getContributor(): Collection
    {
        return $this->contributor;
    }

    public function addContributor(User $contributor): static
    {
        if (!$this->contributor->contains($contributor)) {
            $this->contributor->add($contributor);
        }

        return $this;
    }

    public function removeContributor(User $contributor): static
    {
        $this->contributor->removeElement($contributor);

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Tasks $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setProject($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

        return $this;
    }

}
