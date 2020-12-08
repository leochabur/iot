<?php

namespace GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GestionBundle\Form\ventas\CiudadType;
use GestionBundle\Entity\ventas\Ciudad;
use GestionBundle\Form\ventas\ClienteType;
use GestionBundle\Entity\ventas\Cliente;
use Symfony\Component\HttpFoundation\Request;
use GestionBundle\Form\trafico\OrdenServicioType;
use GestionBundle\Entity\trafico\OrdenServicio;
use GestionBundle\Form\trafico\opciones\TurnoClienteType;
use GestionBundle\Entity\trafico\opciones\TurnoCliente;
use GestionBundle\Form\trafico\TurnoType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use GestionBundle\Services\Diagrama;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class DiagramacionController extends Controller
{

    /**
     * @Route("/diagramacion/diagramar", name="diagramar_turno", methods={"POST", "GET"})
     */
    public function nuevaOrdenTurnoAction(Request $request)
    {

        $form = $this->getFormSelectTurno($this->getUser()->getEmpresa());
        if ($request->isMethod('POST')) 
        {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);         
            if ($form->isValid())
            {            
                $data = $form->getData();
                $diagramacion = $this->get('app.diagrama');   
                $orden = $diagramacion->diagramarOrdenServicio($data['turno'], $data['fecha']);
                $em->persist($orden);
                $em->flush();
                $this->addFlash(
                                    'success',
                                    'La orden ha sido almacenada exitosamente!'
                                );
                $ordenes = $em->getRepository(OrdenServicio::class)->getOrdenesServicioEmpresa($this->getUser()->getEmpresa(), $data['fecha']);
                return $this->render('@Gestion/trafico/altaOrdenServicio.html.twig', ['fecha' => $data['fecha'], 'ordenes' => $ordenes, 'form' => $form->createView()]);

            }
        }

        return $this->render('@Gestion/trafico/altaOrdenServicio.html.twig', ['label' => 'Nuevo', 'form' => $form->createView()]);
    }

    private function getFormSelectTurno($empresa)
    {
        $form = $this->createFormBuilder()
                    ->add('turno',
                      EntityType::class, 
                      [
                      'class' => 'GestionBundle:trafico\Turno',
                      'query_builder' => function (EntityRepository $er) use ($empresa){
                                                                                        return $er->createQueryBuilder('t')
                                                                                                  ->join('t.servicio', 's')
                                                                                                  ->join('s.cliente', 'c')
                                                                                                  ->where('s.empresa = :empresa')
                                                                                                  ->andWhere('s.activo = :activo')
                                                                                                  ->andWhere('c.activo = :activo')
                                                                                                  ->setParameter('empresa', $empresa)
                                                                                                  ->setParameter('activo', true)
                                                                                                  ->orderBy('c.razonSocial', 'ASC')
                                                                                                  ->addOrderBy('s.nombre', 'ASC')
                                                                                                  ->addOrderBy('t.horaInicial', 'ASC');
                       },
                       'choice_label' => 'vistaDiagrama'
                      ]
                    )
                    ->add('fecha', DateType::class, [
                        'widget' => 'single_text',
                    ])
                    ->add('diagramar', SubmitType::class, ['label' => 'Diagramar']) 
                    ->setMethod('POST')     
                    ->getForm();
        return $form;
    }

    private function getFormSelectFechaDiagrama($fecha = null)
    {
        $form = $this->createFormBuilder()
                    ->add('fecha', DateType::class, [
                        'widget' => 'single_text',
                        'data' => $fecha
                    ])
                    ->add('diagramar', SubmitType::class, ['label' => 'Cargar Servicios']) 
                    ->setMethod('POST')     
                    ->getForm();
        return $form;
    }

    /**
     * @Route("/diagramacion/view/{fecha}", name="ver_diagrama_servicios", methods={"POST", "GET"})
     * @ParamConverter("fecha", options={"format": "Y-m-d"})
     */
    public function verDiagramaServiciosAction(\DateTime $fecha = null, Request $request)
    {
        $form = $this->getFormSelectFechaDiagrama($fecha);
        if ($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $data = $form->getData();
                $ordenes = $em->getRepository(OrdenServicio::class)->getOrdenesServicioEmpresa($this->getUser()->getEmpresa(), $data['fecha']);
                return $this->render('@Gestion/trafico/verDiagramaServicios.html.twig', ['fecha' => $data['fecha'], 'ordenes' => $ordenes, 'form' => $form->createView()]);
            }
        }

        if ($fecha)
        {
            $em = $this->getDoctrine()->getManager();
            $ordenes = $em->getRepository(OrdenServicio::class)->getOrdenesServicioEmpresa($this->getUser()->getEmpresa(), $fecha->format('Y-m-d'));
            return $this->render('@Gestion/trafico/verDiagramaServicios.html.twig', ['fecha' => $fecha, 'ordenes' => $ordenes, 'form' => $form->createView()]);
        }
        return $this->render('@Gestion/trafico/verDiagramaServicios.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/diagramacion/update/{id}", name="modificar_orden")
     * @ParamConverter("orden", class="GestionBundle:trafico\OrdenServicio")
     */
    public function modificarOrdenServicioAction(OrdenServicio $orden)
    {
        if ($orden->getTurno()->getServicio()->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }

        $url = $this->generateUrl('procesar_modificar_orden', ['id' => $orden->getId()]);
        $form = $this->getFormAltaOrdenServicio($orden, $url);
        return $this->render('@Gestion/trafico/editarOrdenServicio.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/diagramacion/updateproc/{id}", name="procesar_modificar_orden", methods={"POST"})
     * @ParamConverter("orden", class="GestionBundle:trafico\OrdenServicio")
     */
    public function procesarModificarOrdenServicioAction(OrdenServicio $orden, Request $request)
    {
        if ($orden->getTurno()->getServicio()->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }

        $url = $this->generateUrl('procesar_modificar_orden', ['id' => $orden->getId()]);
        $form = $this->getFormAltaOrdenServicio($orden, $url);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash(
                                'success',
                                'Orden modificada exitosamente!'
                            );
            return $this->redirectToRoute('ver_diagrama_servicios', ['fecha' => $orden->getFecha()->format('Y-m-d')]);
        }
        
        return $this->render('@Gestion/trafico/editarOrdenServicio.html.twig', ['form' => $form->createView()]);
    }


    private function getFormAltaOrdenServicio($orden, $route)
    {
        return $this->createForm(OrdenServicioType::class, $orden, ['empresa' => $this->getUser()->getEmpresa(), 'action' => $route]);
    }

}
