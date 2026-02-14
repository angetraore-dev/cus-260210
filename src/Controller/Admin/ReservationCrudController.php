<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Enum\ReservationStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('clientName', 'Customer'),
            EmailField::new('email', 'Email'),
            IntegerField::new('phone', 'Phone Number'),
            IntegerField::new('guestCount', 'Number of place settings'),
            DateTimeField::new('reservationAt', 'Date and Time'),
            ChoiceField::new('status', 'Status')
                ->setChoices([
                    'Pending' => ReservationStatus::PENDING,
                    'Confirmed' => ReservationStatus::CONFIRMED,
                    'Cancelled' => ReservationStatus::CANCELLED,
                ])
                ->renderAsBadges([
                    ReservationStatus::PENDING->value => 'warning',
                    ReservationStatus::CONFIRMED->value => 'success',
                    ReservationStatus::CANCELLED->value => 'danger',
                ]),
            DateTimeField::new('createdAt', 'Vytvořeno')->hideOnForm(),
        ];
    }
}
