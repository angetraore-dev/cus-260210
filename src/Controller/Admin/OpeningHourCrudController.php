<?php

namespace App\Controller\Admin;

use App\Entity\OpeningHour;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class OpeningHourCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OpeningHour::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('day', 'Den (ex: Pondělí)'),

            TimeField::new('opening_time', 'Otevírá v')
                ->setFormat('HH:mm'),

            TimeField::new('closingTime', 'Zavírá v')
                ->setFormat('HH:mm'),

            BooleanField::new('isClosed', 'Zavřeno (Celý den)'),
        ];
    }

}
