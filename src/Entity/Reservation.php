<?php

namespace App\Entity;

use App\Enum\ReservationStatus;
use App\Repository\ReservationRepository;
use BcMath\Number;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $guest_name = null;

    #[ORM\Column(length: 255)]
    private ?string $guest_email = null;

    #[ORM\Column(length: 255)]
    private ?string $guest_phone = null;

    #[ORM\Column]
    private ?\DateTime $reservation_date = null;

    #[ORM\Column(type: 'integer')]
    private ?Int $nb_persons = null;

    #[ORM\Column(enumType: ReservationStatus::class)]
    private ?ReservationStatus $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuestName(): ?string
    {
        return $this->guest_name;
    }

    public function setGuestName(string $guest_name): static
    {
        $this->guest_name = $guest_name;

        return $this;
    }

    public function getGuestEmail(): ?string
    {
        return $this->guest_email;
    }

    public function setGuestEmail(string $guest_email): static
    {
        $this->guest_email = $guest_email;

        return $this;
    }

    public function getGuestPhone(): ?string
    {
        return $this->guest_phone;
    }

    public function setGuestPhone(string $guest_phone): static
    {
        $this->guest_phone = $guest_phone;

        return $this;
    }

    public function getReservationDate(): ?\DateTime
    {
        return $this->reservation_date;
    }

    public function setReservationDate(\DateTime $reservation_date): static
    {
        $this->reservation_date = $reservation_date;

        return $this;
    }

    public function getNbPersons(): ?Int
    {
        return $this->nb_persons;
    }

    public function setNbPersons(int $nb_persons): static
    {
        $this->nb_persons = $nb_persons;

        return $this;
    }

    public function getStatus(): ?ReservationStatus
    {
        return $this->status;
    }

    public function setStatus(ReservationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
