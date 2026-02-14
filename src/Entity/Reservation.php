<?php

namespace App\Entity;

use App\Enum\ReservationStatus;
use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: ReservationStatus::class)]
    private ?ReservationStatus $status = ReservationStatus::PENDING;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Prosím, zadejte své jméno.')]
    #[Assert\Length(min: 2, minMessage: 'Jméno musí mít alespoň {{ limit }} znaky.')]
    private ?string $clientName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Prosím, zadejte svůj e-mail.')]
    #[Assert\Email(message: 'Zadejte prosím platnou e-mailovou adresu.')]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank(message: 'Prosím, zadejte své telefonní číslo.')]
    // Regex simple pour valider un format de téléphone (ex: +420 123 456 789)
    #[Assert\Regex(
        pattern: '/^[0-9\-\+\s\(\)]+$/',
        message: 'Telefonní číslo není platné.'
    )]
    private ?string $phone = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Prosím, zadejte počet osob.')]
    #[Assert\Range(notInRangeMessage: 'Počet osob musí být mezi {{ min }} a {{ max }}.',
        min: 1,
        max: 20
    )]
    private ?int $guestCount = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Prosím, vyberte datum a čas.')]
    #[Assert\GreaterThan(
        value: 'today',
        message: 'Datum rezervace musí být v budoucnosti.'
    )]
    private ?\DateTimeImmutable $reservationAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        // On initialise la date de création au moment de l'instanciation
        $this->createdAt = new \DateTimeImmutable();
        // On définit aussi le statut par défaut ici si ce n'est pas fait dans la propriété
        $this->status = ReservationStatus::PENDING;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGuestCount(): ?int
    {
        return $this->guestCount;
    }

    public function setGuestCount(int $guestCount): static
    {
        $this->guestCount = $guestCount;

        return $this;
    }

    public function getReservationAt(): ?\DateTimeImmutable
    {
        return $this->reservationAt;
    }

    public function setReservationAt(\DateTimeImmutable $reservationAt): static
    {
        $this->reservationAt = $reservationAt;

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
}
