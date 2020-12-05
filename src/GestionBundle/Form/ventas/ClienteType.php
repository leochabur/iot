<?php

namespace GestionBundle\Form\ventas;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ClienteType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('razonSocial')
                ->add('domicilioFiscal')
                ->add('cuit')      
                ->add('contacto')      
                ->add('telefono')                
                ->addEventListener(
                    FormEvents::PRE_SET_DATA,
                    [$this, 'onPreSetData']
                );
    }

    public function onPreSetData(FormEvent $event)
    {
        $cliente = $event->getData();
        $form = $event->getForm();
        $label = 'Guardar';
        if ($cliente->getId())
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
            'data_class' => 'GestionBundle\Entity\ventas\Cliente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_ventas_cliente';
    }


}
