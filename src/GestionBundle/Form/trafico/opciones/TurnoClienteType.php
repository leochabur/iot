<?php

namespace GestionBundle\Form\trafico\opciones;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TurnoClienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('turno')
                ->addEventListener(
                                    FormEvents::PRE_SET_DATA,
                                    [$this, 'onPreSetData']
                );
    }

    public function onPreSetData(FormEvent $event)
    {
        $turno = $event->getData();
        $form = $event->getForm();
        $label = 'Guardar';
        if ($turno->getId())
        {
            $label = 'Modificar';
        }
        $form->add('guardar', SubmitType::class, ['label' => $label]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\trafico\opciones\TurnoCliente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_trafico_opciones_turnocliente';
    }


}
