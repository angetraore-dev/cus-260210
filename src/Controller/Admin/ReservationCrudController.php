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
            TextField::new('guest_name', 'Customer'),
            EmailField::new('guest_email', 'Email'),
            IntegerField::new('nb_persons', 'Number of place settings'),
            DateTimeField::new('reservation_date', 'Date and Time'),
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
        ];
    }
}
