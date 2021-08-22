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
use GestionBundle\Entity\comunicacion\OrdenInformada;
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
use Symfony\Component\HttpFoundation\JsonResponse;

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
                $empresa = $this->getUser()->getEmpresa();
                $data = $form->getData();
                $diagramacion = $this->get('app.diagrama');   
                $orden = $diagramacion->diagramarOrdenServicio($data['turno'], $data['fecha'], $empresa);
                $orden->setUserAlta($this->getUser());
                $orden->updateCreate();
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

    /**
     * @Route("/diagramacion/comunicar/{fecha}", name="comunicar_diagrama_servicios", methods={"POST", "GET"})
     * @ParamConverter("fecha", options={"format": "Y-m-d"})
     */
    public function comunicarDiagramaServiciosAction(\DateTime $fecha = null, Request $request)
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
                return $this->render('@Gestion/trafico/comunicarServicios.html.twig', ['fecha' => $data['fecha'], 'ordenes' => $ordenes, 'form' => $form->createView()]);
            }
        }

        if ($fecha)
        {
            $em = $this->getDoctrine()->getManager();
            $ordenes = $em->getRepository(OrdenServicio::class)->getOrdenesServicioEmpresa($this->getUser()->getEmpresa(), $fecha->format('Y-m-d'));
            return $this->render('@Gestion/trafico/comunicarServicios.html.twig', ['fecha' => $fecha, 'ordenes' => $ordenes, 'form' => $form->createView()]);
        }
        return $this->render('@Gestion/trafico/comunicarServicios.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/diagramacion/comunicarorden/{id}", name="comunicar_orden_servicio")
     */
    public function comunicarOrdenServiciosAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(OrdenServicio::class);
        try
        {
            $orden = $repository->getOrdenServicioEmpresa($this->getUser()->getEmpresa(), $id);
        }
        catch (\Exception $e) {
                                return new JsonResponse(['data' => $e->getMessage()]);
                                }

        if (!$orden->getUnidad())
        {
            return new JsonResponse(['error' => true, 'message' => 'Debe cargarle una unidad a la orden para poder comunicarla!']);
        }

        if ($orden)
        {
            $path = $this->getUser()->getEmpresa()->getUrl();
            if ($path)
            {

                      $export = [$orden->getOrdenAsArray()];

                      $payload = json_encode($export);
                      $curl = curl_init();
                      curl_setopt_array($curl, array(
                        CURLOPT_URL => "$path",
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS =>"{'trips':$payload}",
                        CURLOPT_RETURNTRANSFER => 1, 
                        CURLOPT_HTTPHEADER => array(
                          "Authorization: Bearer d8Ypl7DMuQsHjjW/INIHxRXjiV1BSezxrmbTV8EWZvk=",
                          "Content-Type: text/plain"
                        ),
                      ));
                      $response = curl_exec($curl);        



                      $json = json_decode($response, true);
                      if (isset($json['success']))
                      {
                          $result = $json['success'];
                      }
                      else
                      {
                          $result = 0;
                      }
                      try
                      {
                            $mensaje = '';
                            foreach ($json['errors'] as $m)
                            {
                                if ($mensaje)
                                    $mensaje.=", ";
                                $mensaje.= $m;
                            }

                          $oi = new OrdenInformada();
                          $oi->setFecha(new \DateTime());
                          $oi->setRequest($payload);
                          $oi->setRespuestaJson($response);
                          $oi->setStatus($result);
                          $oi->setMensajeRespuesta($mensaje);
                          $oi->setOrden($orden);
                          $em = $this->getDoctrine()->getManager();
                          $em->persist($oi);
                          $em->flush();
                     }
                     catch(\Exception $e){return new JsonResponse(['error' => true, 'message' => $e->getMessage()]);}
                      return new JsonResponse(['error' => ($result?false:true), 'message' => $mensaje]);
            }
            return new JsonResponse(['error' => true, 'message' => 'La empresa no tiene configurada la URL donde comunicar los servicios!.']);
        }
    }


    /**
     * @Route("/diagramacion/undo/{stamp}", name="deshacer_replicar_diagrama_servicios")
     */
    public function deshacerReplicaDiagramaAction($stamp)
    {
        $delay = (5 * 60);
        $fecha = new \DateTime();
        $fecha = $fecha->getTimestamp();

        $form = $this->getFormReplicarDiagrama();

        if (($fecha - $stamp) > $delay)
        {
            $this->addFlash('error', 'Se ha excedido el tiempo para realizar esta accion!');
        }
        else
        {
            $em = $this->getDoctrine()->getEntityManager();
            $user = $this->getUser();
            $ordenesAEliminar = $em->getRepository(OrdenServicio::class)->getOrdenServicioEmpresaConStamp($user->getEmpresa(), $stamp);
            $fecha = new \DateTime();
            $fecha = $fecha->getTimestamp();
            foreach ($ordenesAEliminar as $ord)
            {
                $ord->setActiva(false);
                $ord->setUserBaja($user);
                $ord->setStampBaja($fecha);
            }
            $em->flush();
            $this->addFlash('success', 'Se han eliminado exitosamente las ordenes de servicio!');            
        }
        return $this->redirectToRoute('replicar_diagrama_servicios');
    }


    /**
     * @Route("/diagramacion/replicar", name="replicar_diagrama_servicios", methods={"POST", "GET"})
     */
    public function replicarDiagramaServiciosAction( Request $request)
    {
        $form = $this->getFormReplicarDiagrama();
        if ($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);
            if ($form->isValid())
            {
                try
                {
                    $data = $form->getData();
                    $ordenes = $em->getRepository(OrdenServicio::class)->getOrdenesServicioEmpresa($this->getUser()->getEmpresa(), $data['origen']);
                    $diagramacion = $this->get('app.diagrama');   

                    $fecha = new \DateTime();
                    $fecha = $fecha->getTimestamp();

                    $empresa = $this->getUser()->getEmpresa();

                    foreach ($ordenes as $ord)
                    {
                        $destino = $diagramacion->diagramarOrdenServicio($ord->getTurno(), $data['destino'], $empresa);
                        $destino->setUnidad($ord->getUnidad());
                        $destino->setConductor1($ord->getConductor1());
                        $destino->setConductor2($ord->getConductor2());
                        $destino->setUserAlta($this->getUser());
                        $destino->setStampAlta($fecha);
                        $em->persist($destino);
                    }
                    $em->flush();
                    return $this->render('@Gestion/trafico/replicarDiagrama.html.twig', ['form' => $form->createView(), 'status' => 'success', 'stamp' => $fecha]);
                }
                catch (\Exception $e) {

                }
            }
        }
        return $this->render('@Gestion/trafico/replicarDiagrama.html.twig', ['form' => $form->createView()]);
    }

    private function getFormReplicarDiagrama()
    {
        $form = $this->createFormBuilder()
                    ->add('origen', DateType::class, [
                        'widget' => 'single_text',
                    ])
                    ->add('destino', DateType::class, [
                        'widget' => 'single_text'
                    ])
                    ->add('diagramar', SubmitType::class, ['label' => 'Replicar Diagrama']) 
                    ->setMethod('POST')     
                    ->getForm();
        return $form;
    }

    /**
     * @Route("/diagramacion/detail", name="detalle_diagrama_servicios", methods={"POST", "GET"})
     */
    public function detalleDiagramaDiarioAction(Request $request)
    {
        $fecha = $request->request->get('fecha');
        $em = $this->getDoctrine()->getManager();
        $ordenes = $em->getRepository(OrdenServicio::class)->getOrdenesServicioEmpresa($this->getUser()->getEmpresa(), $fecha);
        return $this->render('@Gestion/trafico/verDiagramaServicios.html.twig', ['fecha' => $fecha, 'ordenes' => $ordenes, 'onlyTable' => true]);

    }

}
