<?php

namespace GestionBundle\Form\segVial;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UnidadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('interno')
                ->add('chasisMarca')
                ->add('chasisModelo')
                ->add('carroceriaMarca')
                ->add('carroceriaModelo')
                ->add('capacidad')
                ->add('dominio')
                ->add('anioModelo')
                ->addEventListener(
                                    FormEvents::PRE_SET_DATA,
                                    [$this, 'onPreSetData']
                );
                
    }

    public function onPreSetData(FormEvent $event)
    {
        $unidad = $event->getData();
        $form = $event->getForm();
        $label = 'Guardar';
        if ($unidad->getId())
        {
            $label = 'Modificar';
            $form->add('activo');
        }
        $form->add('guardar', SubmitType::class, ['label' => $label]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\segVial\Unidad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_segvial_unidad';
    }


}
