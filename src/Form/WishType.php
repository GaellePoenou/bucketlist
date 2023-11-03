<?php

namespace App\Form;

use App\Entity\Wish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Your idea', 'required' => true])
            ->add('description', TextType::class, ['label' => 'Please describe it!', 'required' => true])
            ->add('author', TextType::class, ['label' => 'Your username', 'required' => true])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'name', // Nom de la propriété de la catégorie à afficher dans la liste déroulante
                'placeholder' => 'Choose a category', // Texte d'invite
                'required' => true
            ]); // Définissez-le sur true si la catégorie est obligatoire;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
