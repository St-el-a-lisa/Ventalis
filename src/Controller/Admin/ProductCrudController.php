<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{  
    public const PRODUCT_BASE_PATH = 'upload/images/products';
    public const PRODUCT_UPLOAD_DIR = 'public/upload/images/products';

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm(); 
        yield TextField::new('name', 'Label'); 
        yield SlugField::new('slug')->setTargetFieldName('name'); 

        yield TextEditorField::new('description'); 
        yield MoneyField::new('price')->setCurrency('EUR'); 

        yield ImageField::new('image')
            ->setBasePath(self::PRODUCT_BASE_PATH )
            ->setUploadDir(self::PRODUCT_UPLOAD_DIR)
            ->setSortable(false); 

        yield AssociationField::new('categories')->setQueryBuilder(function(QueryBuilder $queryBuilder){
                // dd($queryBuilder->getDQL());
                $queryBuilder->where('entity.active = true');
            });

        yield BooleanField::new('active');
        yield TextareaField::new('featuredText', 'Texte mis en avant(100 caractères)');

        yield  DateTimeField::new('createdAt')->hideOnForm(); 
        yield  DateTimeField::new('updatedAt')->hideOnForm();
        
    }
   

 
}
