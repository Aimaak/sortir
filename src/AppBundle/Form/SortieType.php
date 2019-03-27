<?php

namespace AppBundle\Form;

use AppBundle\Entity\Lieu;
use AppBundle\Entity\Ville;
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
use Symfony\Component\Validator\Constraints\Date;

class SortieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('nom', TextType::class, ['label' => 'Nom de la sortie : '])
            ->add('datedebut', DateTimeType::class, array(
                        'years' => range(date('Y'), date('Y') + 100),
                        'months' => range(date('m'), 12),
                        'days' => range(date('d'), 31),
                        'hours' => range(\date('h'), 23),
                        'minutes' => range(\date('i'), 59),
                        'label' => 'Date et heure de la sortie'))
            ->add('datecloture', DateType::class, array('years' => range(date('Y'), date('Y') + 10),
                        'months' => range(date('m'), 12),
                        'days' => range(date('d'), 31),
                        'label' => 'Date limite d\'inscription'))
            ->add('nbinscriptionsmax', NumberType::class, ['label' => 'Nombre de places : '])
            ->add('duree', NumberType::class, ['label' => 'Durée'])
            ->add('descriptioninfos', TextareaType::class, ['label' => 'Description et infos : '])
            ->add('site', EntityType::class, ["class" => "AppBundle\Entity\Site",
                                                        'label' => "Ville organisatrice"])
            ->add('lieu', EntityType::class, ["class" => Lieu::class])
            ->add("enregistrer", SubmitType::class)
            ->add("Publier_la_sortie", SubmitType::class);

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
