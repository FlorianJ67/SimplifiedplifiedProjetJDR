<?php

namespace App\Form;

use App\Entity\Perso;
use App\Form\InventaireType;

use App\Form\CompetencePersoType;
use App\Form\CaracteristiquePersoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PersoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('espece')
            ->add('origine')
            ->add('age')
            ->add('sante')
            ->add('santeMax')
            ->add('taille')
            ->add('poids')
            ->add('sex')

            ->add('caracteristiquePersos', CollectionType::class, [
                'entry_type' =>CaracteristiquePersoType::class,
                'label' => 'Caractéristique',
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('competencePersos', CollectionType::class, [
                'entry_type' =>CompetencePersoType::class,
                'label' => 'Compétence',
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('inventaires', CollectionType::class, [
                'entry_type' =>InventaireType::class,
                'label' => 'Inventaire',
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Créer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Perso::class,
        ]);
    }
}
