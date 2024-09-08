<?php

namespace App\Form;

use App\Entity\Shoplist;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoplistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', ChoiceType::class, [
                'label' => 'Oddělení',
                'choices' => [
                    'Ovoce a zelenina'=> 'Ovoce a zelenina',
                    'Pečivo' => 'Pečivo',
                    'Konzervy' => 'Konzervy',
                    'Luštěniny' => 'Luštěniny',
                    'Pečení' => 'Pečení',
                    'Drogerie' => 'Drogerie',
                    'Cerealie' => 'Cereálie',
                    'Sýr a salám' => 'Sýr a salám',
                    'Maso' => 'Maso',
                    'Mléčné výrobky' => 'Mléčné výrobky',
                    'Chlazené pochoutky' => 'Chlazené pochoutky',
                    'Sladkosti' => 'Sladkosti',
                    'Slané pochoutky' => 'Slané pochoutky',
                    'Nápoje' => 'Nápoje',
                    'Alkohol' => 'Alkohol',
                    'Mražené potraviny' => 'Mražené potraviny',
                    'Dětská výživa' => 'Dětská výživa'
                ],
            ])
            ->add('sort', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['label' => 'Sortiment'])
            ->add('quantity', NumberType::class, ['label' => 'Množství'])
            ->add('units', ChoiceType::class, [
                'label' => 'Jednotky',
                'choices'=> [
                    'Kus' => 'Kus',
                    'Kilogram' => 'Kilogram',
                    'Gram' => 'Gram',
                    'Litr' => 'Litr',
                    'Balení' => 'Balení'
                ],
                ])
            ->add('selectprice', ChoiceType::class, [
                'label' => 'Vyberte cenu',
                'choices'=> [
                    'Neuvedeno' => 'Neuvedeno',
                    'Maximální cena za jednotku' => 'Cena max.',
                    'Přesná cena za jednotku' => 'Cena',
                ],
                ])
            ->add('value', NumberType::class, ['label' => 'Hodnota (Kč)','required' => false])
            ->add('comment', TextareaType::class, ['label' => 'Komentář', 'required' => false])
            ->add('save', SubmitType::class, ['label' => 'Uložit']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shoplist::class,
        ]);
    }
}
