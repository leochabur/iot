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

class ServicioType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $empresa = $options['empresa'];
        $builder->add('nombre')
                ->add('kmRecorrido')
                ->add('cliente',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:ventas\Cliente',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('c')
                                                                                                  ->where('c.empresa = :empresa')
                                                                                                  ->andWhere('c.activo = :activo')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->setParameter('activo', true)
                                                                                                  ->orderBy('c.razonSocial', 'ASC');
                       }
                      ]
                    )
                ->add('origen',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:ventas\Ciudad',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('c')
                                                                                                  ->where('c.empresa = :empresa')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->orderBy('c.nombre', 'ASC');
                       }
                      ]
                    )
                ->add('destino',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:ventas\Ciudad',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('c')
                                                                                                  ->where('c.empresa = :empresa')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->orderBy('c.nombre', 'ASC');
                       }
                      ]
                    )
                ->add('sentido')
                ->add('tipoServicio',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:trafico\opciones\TipoServicio',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('t')
                                                                                                  ->where('t.empresa = :empresa')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->orderBy('t.tipo', 'ASC');
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
        $servicio = $event->getData();
        $form = $event->getForm();
        $label = 'Guardar';
        if ($servicio->getId())
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
                        'data_class' => 'GestionBundle\Entity\trafico\Servicio'
                    ))
                 ->setRequired('empresa');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_trafico_servicio';
    }


}
