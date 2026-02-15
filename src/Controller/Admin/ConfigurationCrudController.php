<?php

namespace App\Controller\Admin;

use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ConfigurationCrudController extends AbstractCrudController
{
    private ConfigurationRepository $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository){
        $this->configurationRepository = $configurationRepository;
    }
    public static function getEntityFqcn(): string
    {
        return Configuration::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('siteName', 'Název webu'),
            EmailField::new('contactEmail', 'Kontaktní E-mail'),
            TextField::new('phoneNumber', 'Telefonní číslo'),
            TextareaField::new('address', 'Adresa (každý řádek nový řádek)'),
            UrlField::new('googleMapsLink', 'Odkaz na Google Maps'),
            UrlField::new('facebookLink', 'Facebook URL'),
            UrlField::new('instagramLink', 'Instagram URL'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $configCount = $this->configurationRepository->count([]);

        if ($configCount > 0) {
            // On empêche la création et la suppression si une config existe
            return $actions
                ->disable(Action::NEW, Action::DELETE);
        }

        return $actions;
    }

}
