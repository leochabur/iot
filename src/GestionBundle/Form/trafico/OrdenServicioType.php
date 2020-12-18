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
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OrdenServicioType extends AbstractType
{
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $empresa = $options['empresa'];
        $builder->add('salida', DateTimeType::class, ['widget' => 'single_text'])
                ->add('llegada', DateTimeType::class, ['widget' => 'single_text'])
                ->add('activa')                
                ->add('guardar', SubmitType::class, ['label' => 'Modificar'])
                ->add('unidad',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:segVial\Unidad',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('u')
                                                                                                  ->where('u.empresa = :empresa')
                                                                                                  ->andWhere('u.activo = :activo')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->setParameter('activo', true)
                                                                                                  ->orderBy('u.interno', 'ASC');
                       },
                       'required' => false
                      ]
                    )
                ->add('conductor1',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:rrhh\Conductor',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('u')
                                                                                                  ->where('u.empresa = :empresa')
                                                                                                  ->andWhere('u.activo = :activo')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->setParameter('activo', true)
                                                                                                  ->orderBy('u.apellido', 'ASC');
                       },
                       'required' => false
                      ]
                    )
                ->add('conductor2',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:rrhh\Conductor',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('u')
                                                                                                  ->where('u.empresa = :empresa')
                                                                                                  ->andWhere('u.activo = :activo')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->setParameter('activo', true)
                                                                                                  ->orderBy('u.apellido', 'ASC');
                       },
                       'required' => false
                      ]
                    )
                ->addEventListener(
                                    FormEvents::PRE_SET_DATA,
                                    [$this, 'onPreSetData']
                );
    }

    public function onPreSetData(FormEvent $event)
    {
        $orden = $event->getData();
        $form = $event->getForm();
        $form->add('cliente', EntityType::class, ['class' => 'GestionBundle:ventas\Cliente', 'mapped' => false, 'choices' => [$orden->getTurno()->getServicio()->getCliente()]])
             ->add('turno', EntityType::class, ['class' => 'GestionBundle:trafico\Turno', 'choice_label' => 'vistaDiagrama', 'choices' => [$orden->getTurno()]]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\trafico\OrdenServicio'
        ))
        ->setRequired('empresa');

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_trafico_ordenservicio';
    }


}
