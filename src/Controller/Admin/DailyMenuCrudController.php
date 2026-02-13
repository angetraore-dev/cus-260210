<?php

namespace App\Controller\Admin;

use App\Entity\DailyMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class DailyMenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailyMenu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Validity Period')
                ->setIcon('fa fa-calendar-alt'),

            // "Subtitle" logic: The period dates
            DateField::new('startDate', 'Valid From')
                ->setColumns(6),
            DateField::new('endDate', 'Valid Until')
                ->setColumns(6),

            FormField::addPanel('Menu Content')
                ->setIcon('fa fa-utensils'),

            // The "Add row / Remove row" part
            CollectionField::new('dailyMenuItems', 'Menu Items (Soup & Mains)')
                ->setEntryIsComplex(true)
                ->useEntryCrudForm(DailyMenuItemCrudController::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->setFormTypeOptions([
                    'by_reference' => false
                ])
                ->setHelp('Add rows for daily soups and main courses. Each row has a title, description, and price.')
                ->setColumns(12),
        ];

        //CollectionField::new('dailyMenuItems')
        //                ->setEntryType(DailyMenuItemType::class)
        //                ->setFormTypeOptions([
        //                    'by_reference' => false, // OBLIGATOIRE pour les relations OneToMany
        //                ])
        //                ->setHelp('Ajoutez les soupes et les plats du jour. Chaque ligne contient un titre, une description et un prix.')
        //                ->setColumns(12)
        //                ->allowAdd()
        //                ->allowDelete()
        //                ->setEntryIsComplex(true),
    }
}
