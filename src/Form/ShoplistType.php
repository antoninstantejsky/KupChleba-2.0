<?php

namespace App\Form;

use App\Entity\Shoplist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoplistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category')
            ->add('sort')
            ->add('quantity')
            ->add('units')
            ->add('selectprice')
            ->add('value')
            ->add('comment')
            ->add('save', type: SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shoplist::class,
        ]);
    }
}
