<?php

namespace AppBundle\Form;

use AppBundle\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
            ->add('datedebut', DateTimeType::class)
            ->add('datecloture', DateType::class)
            ->add('nbinscriptionsmax', NumberType::class)
            ->add('duree', NumberType::class)
            ->add('descriptioninfos', TextareaType::class)
            ->add('lieu', EntityType::class, ["class" => "AppBundle\Entity\Lieu"])
            ->add('site', EntityType::class, ["class" => "AppBundle\Entity\Site"])
            ->add('Etat', EntityType::class, ["class" => "AppBundle\Entity\Etat"])
            ->add('Organisateur', EntityType::class, ["class" => "AppBundle\Entity\Participant"])
            ->add("enregistrer", SubmitType::class)
            ->add("Publier la sortie", SubmitType::class);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Sortie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_sortie';
    }


}
