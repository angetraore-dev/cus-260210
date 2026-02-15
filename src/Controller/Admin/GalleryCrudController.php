<?php

namespace App\Controller\Admin;

use App\Entity\Gallery;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType; // Vérifie bien l'import

class GalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gallery::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('imageTitle', 'Název (alt text)'),
            // On utilise TextField avec le type Vich pour l'upload
            TextField::new('imageFile', 'Fotografie')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('imageName', 'Náhled')
                ->setBasePath('/uploads/gallery')
                ->hideOnForm(),

            IntegerField::new('priority', 'Priorita (pořadí)'),
        ];
    }

    //ImageField::new('imageName', 'Fotografie')
    //                ->setBasePath('uploads/gallery')
    //                ->setUploadDir('public/uploads/gallery')
    //                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
    //                ->setRequired($pageName === 'new'),

}
