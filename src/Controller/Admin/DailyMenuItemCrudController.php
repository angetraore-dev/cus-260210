<?php

namespace App\Controller\Admin;

use App\Entity\DailyMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DailyMenuItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailyMenuItem::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Dish Name')
                ->setHelp('e.g. Garlic Soup or Beef Goulash'),

            TextareaField::new('description', 'Description')
                ->hideOnIndex(),

            // Using TextField or MoneyField based on your preference
            // SetStoredAsCents(false) if your DB stores 15.50 and not 1550
            MoneyField::new('price', 'Price')
                ->setCurrency('CZK')
                ->setStoredAsCents(false),
        ];
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
