<?php

namespace App\Form;

use App\Entity\Objet;
use App\Entity\Perso;
use App\Entity\Action;
use App\Entity\Competence;
use App\Entity\Caracteristique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('personnage', EntityType::class,[
                'class' => Perso::class
            ])
            ->add('caracteristique', EntityType::class,[
                'class' => Caracteristique::class,
                'required' => false,
            ])
            ->add('competence', EntityType::class,[
                'class' => Competence::class,
                'required' => false,
            ])
            ->add('objet', EntityType::class,[
                'class' => Objet::class,
                'required' => false,
                ])
            ->add('dice', TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Action'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
