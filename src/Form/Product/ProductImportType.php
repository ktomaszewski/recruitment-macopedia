<?php

declare(strict_types=1);

namespace Application\Form\Product;

use Application\Form\Product\Model\ProductImportModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'required'           => true,
                'label'              => 'import.form.file',
                'translation_domain' => 'product'
            ])->add('send', SubmitType::class, [
                'label'              => 'import.form.send',
                'translation_domain' => 'product'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductImportModel::class
        ]);
    }
}
