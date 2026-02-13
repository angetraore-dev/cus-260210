<?php

namespace App\Entity;

use App\Repository\DailyMenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailyMenuRepository::class)]
class DailyMenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, DailyMenuItem>
     */
    #[ORM\OneToMany(
        targetEntity: DailyMenuItem::class,
        mappedBy: 'dailyMenu',
        cascade: ['persist'],
        orphanRemoval: true
    )]
    private Collection $dailyMenuItems;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $endDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    public function __construct()
    {
        $this->dailyMenuItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, DailyMenuItem>
     */
    public function getDailyMenuItems(): Collection
    {
        return $this->dailyMenuItems;
    }

    public function addDailyMenuItem(DailyMenuItem $dailyMenuItem): static
    {
        if (!$this->dailyMenuItems->contains($dailyMenuItem)) {
            $this->dailyMenuItems->add($dailyMenuItem);
            $dailyMenuItem->setDailyMenu($this);
        }

        return $this;
    }

    public function removeDailyMenuItem(DailyMenuItem $dailyMenuItem): static
    {
        if ($this->dailyMenuItems->removeElement($dailyMenuItem)) {
            // set the owning side to null (unless already changed)
            if ($dailyMenuItem->getDailyMenu() === $this) {
                $dailyMenuItem->setDailyMenu(null);
            }
        }

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
