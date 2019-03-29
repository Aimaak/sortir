<?php

namespace AppBundle\Form;

use AppBundle\Entity\Lieu;
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

        $builder->add('nom', TextType::class, ['label' => 'Nom de la sortie : '])
            ->add('datedebut', DateTimeType::class, array(
                        'years' => range(date('Y'), date('Y') + 10),
                        'months' => range(1, 12),
                        'days' => range(1, 31),
                        'hours' => range(0, 23),
                        'minutes' => range(00, 59),
                        'data' => new \DateTime("now + 1 week"),
                        'label' => 'Date et heure de la sortie'))
            ->add('datecloture', DateType::class, array('years' => range(date('Y'), date('Y') + 10),
                        'months' => range(1, 12),
                        'days' => range(1, 31),
                        'data' => new \DateTime("now + 6 days"),
                        'label' => 'Date limite d\'inscription'))
            ->add('nbinscriptionsmax', NumberType::class, ['label' => 'Nombre de places : '])
            ->add('duree', NumberType::class, ['label' => 'Durée'])
            ->add('descriptioninfos', TextareaType::class, ['label' => 'Description et infos : '])
            ->add('site')
            ->add('lieu')
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
