<?php

namespace Fmd\BookingManagementBundle\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Fmd\BookingManagementBundle\Entity\BilletType;
use Fmd\PersonneBundle\Entity\PersonneType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('billets', CollectionType::class, array(
                    'entry_type' => BilletType::class,
                    'entry_options' => array('label' => false),
                    'allow_add' => true))
            ->add('dateReservation',            DateType::class)
            ->add('Soumettre le formulaire',    SubmitType::class)
        ;
    }
}