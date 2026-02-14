<?php

namespace App\Controller\Admin;

use App\Entity\Dish;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DishCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dish::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Název pokrmu'),
            TextEditorField::new('description', 'Popis složení'),
            MoneyField::new('price', 'Cena')
                ->setCurrency("CZK")
                ->setStoredAsCents(false)
                ->setHelp('Cena v českých korunách'),
            AssociationField::new('category', 'Kategorie')
                ->setRequired(true),

            // Le petit interrupteur magique
            BooleanField::new('isAvaible', 'Dostupné')
                ->setHelp('Pokud je vypnuto, pokrm se na webu nezobrazí.')
        ];

    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('category')
            ->add('price');
    }
}
