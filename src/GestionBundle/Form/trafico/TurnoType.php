<?php

namespace GestionBundle\Form\trafico;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class TurnoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $empresa = $options['empresa'];
        $servicio = $options['servicio'];
        $builder->add('horaInicial', TimeType::class, ['widget' => 'single_text'])        
                ->add('duracion', TimeType::class, ['widget' => 'single_text'])
                ->add('servicio',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:trafico\Servicio',
                      'choices' => [$servicio],
                      ]
                  )
                ->add('turno',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:trafico\opciones\TurnoCliente',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('t')
                                                                                                  ->where('t.empresa = :empresa')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->orderBy('t.turno', 'ASC');
                       }
                      ]
                    )
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
            'data_class' => 'GestionBundle\Entity\trafico\Turno'
        ))
        ->setRequired('empresa')
        ->setRequired('servicio');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_trafico_turno';
    }


}
