<?php

namespace App\Form;

use App\Entity\Terms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class TermsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('description', TextareaType::class, [
            //     'label' => 'Descripción:',
            //     'label_attr' => [
            //         'class' => 'form-label',
            //     ],
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            // ])
            ->add('description', CKEditorType::class, [
                'config_name' => 'minima_config',
                'label' => 'Descripción:',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'placeholder' => 'Escriba su articulo',
                    'class' => 'articulo form-control',
                    'block_prefix' => 'articulo_text',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terms::class,
        ]);
    }
}
