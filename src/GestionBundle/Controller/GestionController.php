<?php

namespace GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GestionBundle\Form\ventas\CiudadType;
use GestionBundle\Entity\ventas\Ciudad;
use GestionBundle\Form\ventas\ClienteType;
use GestionBundle\Entity\ventas\Cliente;
use Symfony\Component\HttpFoundation\Request;
use GestionBundle\Form\trafico\ServicioType;
use GestionBundle\Entity\trafico\Servicio;
use GestionBundle\Form\trafico\opciones\TurnoClienteType;
use GestionBundle\Entity\trafico\opciones\TurnoCliente;
use GestionBundle\Form\trafico\TurnoType;
use GestionBundle\Entity\trafico\Turno;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use GestionBundle\Form\segVial\UnidadType;
use GestionBundle\Entity\segVial\Unidad;
use GestionBundle\Form\rrhh\ConductorType;
use GestionBundle\Entity\rrhh\Conductor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class GestionController extends Controller
{

    /**
     * @Route("/home", name="home_page")
     */
    public function principalAction()
    {
        return $this->render('@Gestion/principal.html.twig');
    }

    /**
     * @Route("/opciones/addturn", name="agregar_turno", methods={"POST", "GET"})
     */
    public function nuevoTurnoAction(Request $request)
    {
        $turno = new TurnoCliente();
        $turno->setEmpresa($this->getUser()->getEmpresa());
        $form = $this->getFormAltaTurnoCliente($turno, '');
        if ($request->isMethod('POST')) 
        {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);         
            if ($form->isValid())
            {               
                $em->persist($turno);
                $em->flush();
                $this->addFlash(
                                    'success',
                                    'El turno ha sido almacenado exitosamente!'
                                );
                return $this->redirectToRoute('agregar_turno');
            }
        }

        return $this->render('@Gestion/trafico/opciones/altaTurnoCliente.html.twig', ['label' => 'Nuevo', 'form' => $form->createView()]);
    }

    private function getFormAltaTurnoCliente($turno, $route)
    {
        return $this->createForm(TurnoClienteType::class, $turno, ['action' => $route]);
    }

    /**
     * @Route("/opciones/addcity", name="agregar_ciudad", methods={"POST", "GET"})
     */
    public function nuevaCiudadAction(Request $request)
    {
    	$ciudad = new Ciudad();
    	$ciudad->setEmpresa($this->getUser()->getEmpresa());
    	$form = $this->getFormAltaCiudad($ciudad, '');
    	if ($request->isMethod('POST')) 
    	{
    		$em = $this->getDoctrine()->getManager();
    		$form->handleRequest($request);    		
    		if ($form->isValid())
    		{    			
    			$em->persist($ciudad);
    			$em->flush();
	            $this->addFlash(
	                                'success',
	                                'La ciudad ha sido almacenada exitosamente!'
	                            );
    			return $this->redirectToRoute('agregar_ciudad');
    		}
    	}

        return $this->render('@Gestion/ventas/altaCiudad.html.twig', ['label' => 'Nueva', 'form' => $form->createView()]);
    }

    private function getFormAltaCiudad($ciudad, $route)
    {
		return $this->createForm(CiudadType::class, $ciudad, ['action' => $route]);
    }

    /**
     * @Route("/opciones/listcity", name="listado_ciudad")
     */
    public function listaCiudadesAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$ciudades = $em->getRepository(Ciudad::class)->getCiudadesEmpresa($this->getUser()->getEmpresa());
        return $this->render('@Gestion/ventas/listadoCiudades.html.twig', ['ciudades' => $ciudades]);
    }

    /**
     * @Route("/opciones/editcity/{id}", name="editar_ciudad")
     */
    public function editarCiudadAction($id)
    {
    	$route = $this->generateUrl('procesar_editar_ciudad', ['id' => $id]);
    	$em = $this->getDoctrine()->getManager();
    	$ciudad = $em->find(Ciudad::class, $id);
        if ($ciudad->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
    	$form = $this->getFormAltaCiudad($ciudad, $route);
        return $this->render('@Gestion/ventas/altaCiudad.html.twig', ['label' => 'Modificar', 'form' => $form->createView()]);
    }

    /**
     * @Route("/opciones/editcityprc/{id}", name="procesar_editar_ciudad", methods={"POST"})
     */
    public function editarCiudadProcesarAction($id, Request $request)
    {
    	$route = $this->generateUrl('procesar_editar_ciudad', ['id' => $id]);
    	$em = $this->getDoctrine()->getManager();
    	$ciudad = $em->find(Ciudad::class, $id);
        if ($ciudad->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
    	$form = $this->getFormAltaCiudad($ciudad, $route);	
    	$form->handleRequest($request);	
		if ($form->isValid())
		{    			
			$em->flush();
            $this->addFlash(
                                'success',
                                'La ciudad ha sido modificada exitosamente!'
                            );
			return $this->redirectToRoute('listado_ciudad');
		}
        return $this->render('@Gestion/ventas/altaCiudad.html.twig', ['label' => 'Modificar', 'form' => $form->createView()]);
    }

    /**
     * @Route("/opciones/addclient", name="agregar_cliente", methods={"POST", "GET"})
     */
    public function nuevoClienteAction(Request $request)
    {
    	$cliente = new Cliente();
    	$cliente->setEmpresa($this->getUser()->getEmpresa());
    	$form = $this->getFormAltaCliente($cliente, '');
    	if ($request->isMethod('POST')) 
    	{
    		$em = $this->getDoctrine()->getManager();
    		$form->handleRequest($request);    		
    		if ($form->isValid())
    		{    			
    			$em->persist($cliente);
    			$em->flush();
	            $this->addFlash(
	                                'success',
	                                'El cliente ha sido almacenado exitosamente!'
	                            );
    			return $this->redirectToRoute('agregar_cliente');
    		}
    	}

        return $this->render('@Gestion/ventas/altaCliente.html.twig', ['label' => 'Nuevo', 'form' => $form->createView()]);
    }

    private function getFormAltaCliente($cliente, $route)
    {
		return $this->createForm(ClienteType::class, $cliente, ['action' => $route]);
    }

    /**
     * @Route("/opciones/listclient", name="listado_clientes")
     */
    public function listaClientessAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$clientes = $em->getRepository(Cliente::class)->getClientesEmpresa($this->getUser()->getEmpresa());
        return $this->render('@Gestion/ventas/listadoClientes.html.twig', ['clientes' => $clientes]);
    }

    /**
     * @Route("/opciones/editclient/{id}", name="editar_cliente")
     */
    public function editarClienteAction($id)
    {
    	$route = $this->generateUrl('procesar_editar_ccliente', ['id' => $id]);
    	$em = $this->getDoctrine()->getManager();
    	$cliente = $em->find(Cliente::class, $id);
        if ($cliente->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
    	$form = $this->getFormAltaCliente($cliente, $route);
        return $this->render('@Gestion/ventas/altaCliente.html.twig', ['label' => 'Modificar', 'form' => $form->createView()]);
    }

    /**
     * @Route("/opciones/editclientprc/{id}", name="procesar_editar_ccliente", methods={"POST"})
     */
    public function editarClienteProcesarAction($id, Request $request)
    {
    	$route = $this->generateUrl('procesar_editar_ccliente', ['id' => $id]);
    	$em = $this->getDoctrine()->getManager();
    	$cliente = $em->find(Cliente::class, $id);
        if ($cliente->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
    	$form = $this->getFormAltaCliente($cliente, $route);	
    	$form->handleRequest($request);	
		if ($form->isValid())
		{    			
			$em->flush();
            $this->addFlash(
                                'success',
                                'El cliente ha sido modificado exitosamente!'
                            );
			return $this->redirectToRoute('listado_clientes');
		}
        return $this->render('@Gestion/ventas/altaCliente.html.twig', ['label' => 'Modificar', 'form' => $form->createView()]);
    }

    /////////////////////////Generacion de Servicios
    /**
     * @Route("/opciones/addsrvce", name="agregar_servicio", methods={"POST", "GET"})
     */
    public function nuevoServicioAction(Request $request)
    {
        $servicio = new Servicio();
        $servicio->setEmpresa($this->getUser()->getEmpresa());
        $form = $this->getFormAltaServicio($servicio, '');
        if ($request->isMethod('POST')) 
        {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);         
            if ($form->isValid())
            {               
                $em->persist($servicio);
                $em->flush();
                return $this->redirectToRoute('agregar_horarios', ['id' => $servicio->getId()]);
            }
        }

        return $this->render('@Gestion/trafico/altaServicio.html.twig', ['label' => 'Nuevo', 'form' => $form->createView()]);
    }

    private function getFormAltaServicio($servicio, $route)
    {
        return $this->createForm(ServicioType::class, $servicio, ['empresa' => $this->getUser()->getEmpresa(), 'action' => $route]);
    }

    /**
     * @Route("/opciones/listserv", name="listado_servicios", methods={"POST", "GET"})
     */
    public function listaServiciosAction(Request $request)
    {
        $form = $this->getFormSelectClientes($this->getUser()->getEmpresa());
        if ($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository(Servicio::class);

            $form->handleRequest($request);
            $data = $form->getData();
            if (!$data['cliente'])
            {
                $servicios = $repository->getServiciosEmpresa($this->getUser()->getEmpresa());
            }
            else
            {
                $servicios = $repository->getServiciosOfClienteEmpresa($this->getUser()->getEmpresa(), $data['cliente']);
            }
            return $this->render('@Gestion/trafico/listadoServicios.html.twig', ['servicios' => $servicios, 'form' => $form->createView()]);
        }

        return $this->render('@Gestion/trafico/listadoServicios.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/opciones/editserv/{id}", name="editar_servicio")
     */
    public function editarServicioAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $servicio = $em->find(Servicio::class, $id);
        if ($servicio->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
        $url = $this->generateUrl('procesar_editar_servicio', ['id' => $id]);
        $form = $this->getFormAltaServicio($servicio, $url);
        return $this->render('@Gestion/trafico/altaServicio.html.twig', ['edit' => true, 'srv' => $servicio, 'label' => 'Modificar', 'form' => $form->createView()]);
    }

    /**
     * @Route("/opciones/editservprc/{id}", name="procesar_editar_servicio")
     */
    public function procesarEditarServicioAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $servicio = $em->find(Servicio::class, $id);
        if ($servicio->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
        $url = $this->generateUrl('procesar_editar_servicio', ['id' => $id]);
        $form = $this->getFormAltaServicio($servicio, $url);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em->flush();
            $this->addFlash(
                                'success',
                                'El servicio ha sido modificado exitosamente!'
                            );
            return $this->redirectToRoute('listado_servicios');
        }
        return $this->render('@Gestion/trafico/altaServicio.html.twig', ['edit' => true, 'srv' => $servicio, 'label' => 'Modificar', 'form' => $form->createView()]);
    }

    private function getFormSelectClientes($empresa)
    {
        $form =    $this->createFormBuilder()
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
                           },
                           'empty_data' => null,
                           'required' => false,
                           'placeholder' => 'TODOS'
                          ]
                        )
                        ->add('cargar', SubmitType::class, ['label' => 'Cargar']) 
                        ->setMethod('POST')     
                        ->getForm();
        return $form;
    }

    ////////////Agregar Horarios al Servicio
    /**
     * @Route("/opciones/addtime/{id}", name="agregar_horarios", methods={"POST", "GET"})
     */
    public function nuevoHorarioAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $servicio = $em->find(Servicio::class, $id);
        if ($servicio->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
        $turno = new Turno();
        $turno->setServicio($servicio);

        $form = $this->getFormAltaTurno($turno, $servicio, '');
        if ($request->isMethod('POST')) 
        {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);         
            if ($form->isValid())
            {               
                $em->persist($turno);
                $em->flush();
                $this->addFlash(
                                    'success',
                                    'El turno ha sido almacenado exitosamente!'
                                );
                return $this->redirectToRoute('agregar_horarios', ['id' => $id]);
            }
        }

        return $this->render('@Gestion/trafico/altaTurno.html.twig', ['srv' => $servicio, 'label' => 'Nuevo', 'form' => $form->createView()]);
    }

    private function getFormAltaTurno(Turno $turno, Servicio $servicio, $route)
    {
        return $this->createForm(TurnoType::class, $turno, ['servicio' => $servicio, 'empresa' => $this->getUser()->getEmpresa(), 'action' => $route]);
    }

    /**
     * @Route("/opciones/edittime/{id}", name="editar_horarios")
     */
    public function editarHorarioAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $turno = $em->find(Turno::class, $id);
        $servicio = $turno->getServicio();
        if ($servicio->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
        $url = $this->generateUrl('editar_horarios_procesar', ['id' => $id]);
        $form = $this->getFormAltaTurno($turno, $servicio, $url);
        return $this->render('@Gestion/trafico/altaTurno.html.twig', ['edit' => true, 'srv' => $servicio, 'label' => 'Modificar', 'form' => $form->createView()]);
    }

    /**
     * @Route("/opciones/edittimeprc/{id}", name="editar_horarios_procesar")
     */
    public function procesarEditarHorarioAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $turno = $em->find(Turno::class, $id);
        $servicio = $turno->getServicio();
        if ($servicio->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
        $url = $this->generateUrl('editar_horarios_procesar', ['id' => $id]);
        $form = $this->getFormAltaTurno($turno, $servicio, $url);
        $form->handleRequest($request);
        if ($form->isValid()) 
        {
            $em->flush();
            $this->addFlash(
                                'success',
                                'El turno ha sido modificado exitosamente!'
                            );
            return $this->redirectToRoute('agregar_horarios',['id' => $servicio->getId()]);
        }
        return $this->render('@Gestion/trafico/altaTurno.html.twig', ['edit' => true, 'srv' => $servicio, 'label' => 'Modificar', 'form' => $form->createView()]);
    }

    /////////////////generacion de unidades
    /**
     * @Route("/tecnica/addunit", name="agregar_unidad", methods={"POST", "GET"})
     */
    public function nuevaUnidadAction(Request $request)
    {
        $unidad = new Unidad();
        $unidad->setEmpresa($this->getUser()->getEmpresa());
        $form = $this->getFormAltaUnidad($unidad, '');
        if ($request->isMethod('POST')) 
        {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);         
            if ($form->isValid())
            {               
                $em->persist($unidad);
                $em->flush();
                $this->addFlash(
                                    'success',
                                    'La unidad ha sido almacenada exitosamente!'
                                );
                return $this->redirectToRoute('agregar_unidad');
            }
        }
        return $this->render('@Gestion/segVial/altaUnidad.html.twig', ['label' => 'Nueva', 'form' => $form->createView()]);
    }

    private function getFormAltaUnidad($unidad, $route)
    {
        return $this->createForm(UnidadType::class, $unidad, ['action' => $route]);
    }

    /**
     * @Route("/opciones/listunits", name="listado_unidades")
     */
    public function listaUnidadesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $unidades = $em->getRepository(Unidad::class)->getUnidadesEmpresa($this->getUser()->getEmpresa());
        return $this->render('@Gestion/segVial/listadoUnidades.html.twig', ['unidades' => $unidades]);
    }

    /**
     * @Route("/opciones/editunit/{id}", name="editar_unidad")
     * @ParamConverter("interno", class="GestionBundle:segVial\Unidad")
     */
    public function editarUnidadAction(Unidad $interno)
    {
        if ($interno->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }
        $url = $this->generateUrl('procesar_editar_unidad', ['id' => $interno->getId()]);
        $form = $this->getFormAltaUnidad($interno, $url);
        return $this->render('@Gestion/segVial/altaUnidad.html.twig', ['label' => 'Modificar', 'form' => $form->createView()]);
    }

    /**
     * @Route("/opciones/editunitprc/{id}", name="procesar_editar_unidad", methods={"POST"})
     * @ParamConverter("interno", class="GestionBundle:segVial\Unidad")
     */
    public function procesarEditarUnidadAction(Unidad $interno, Request $request)
    {
        if ($interno->getEmpresa() !== $this->getUser()->getEmpresa())
        {
            $this->addFlash(
                                'error',
                                'No posee permisos para acceder a esta URL!'
                            );
            return $this->redirectToRoute('home_page');
        }

        $url = $this->generateUrl('procesar_editar_unidad', ['id' => $interno->getId()]);
        $form = $this->getFormAltaUnidad($interno, $url);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash(
                                'success',
                                'La unidad ha sido modificada exitosamente!'
                            );
            return $this->redirectToRoute('listado_unidades');
        }
        return $this->render('@Gestion/segVial/altaUnidad.html.twig', ['label' => 'Modificar', 'form' => $form->createView()]);
    }

    /////////////////generacion de empleados
    /**
     * @Route("/rrhh/adddrive", name="agregar_conductor", methods={"POST", "GET"})
     */
    public function nuevoConductorAction(Request $request)
    {
        $conductor = new Conductor();
        $conductor->setEmpresa($this->getUser()->getEmpresa());
        $form = $this->getFormAltaConductor($conductor, '');
        if ($request->isMethod('POST')) 
        {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);         
            if ($form->isValid())
            {               
                $em->persist($conductor);
                $em->flush();
                $this->addFlash(
                                    'success',
                                    'El conductor ha sido almacenado exitosamente!'
                                );
                return $this->redirectToRoute('agregar_conductor');
            }
        }
        return $this->render('@Gestion/rrhh/altaConductor.html.twig', ['label' => 'Nuevo', 'form' => $form->createView()]);
    }

    private function getFormAltaConductor($conductor, $route)
    {
        return $this->createForm(ConductorType::class, $conductor, ['action' => $route]);
    }

    /**
     * @Route("/rrhh/lista", name="listar_conductor")
     */
    public function listarConductoresAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Conductor::class);
        $conductores = $repository->getConductoresEmpresa($this->getUser()->getEmpresa());
        return $this->render('@Gestion/rrhh/listadoConductores.html.twig', ['conductores' => $conductores]);
    }

    /**
     * @Route("/rrhh/editar/{id}", name="editar_conductor")
     */
    public function editarConductorAction($id)
    {
        $conductor = $this->getDoctrine()->getManager()->find(Conductor::class, $id);
        $conductor->setEmpresa($this->getUser()->getEmpresa());
        $url = $this->generateUrl('procesar_agregar_conductor', ['id' => $id]);
        $form = $this->getFormAltaConductor($conductor, $url);
        return $this->render('@Gestion/rrhh/altaConductor.html.twig', ['label' => 'Moificar', 'form' => $form->createView()]);
    }

    /**
     * @Route("/rrhh/editarprc/{id}", name="procesar_agregar_conductor", methods={"POST"})
     */
    public function procesarEditarConductorAction($id, Request $request)
    {
        $conductor = $this->getDoctrine()->getManager()->find(Conductor::class, $id);
        $url = $this->generateUrl('procesar_agregar_conductor', ['id' => $id]);
        $form = $this->getFormAltaConductor($conductor, $url);
        $form->handleRequest($request); 
        $em = $this->getDoctrine()->getManager();
        if ($form->isValid())
        {               
            $em->flush();
            $this->addFlash(
                                'success',
                                'El conductor ha sido modificado exitosamente!'
                            );
            return $this->redirectToRoute('listar_conductor');
        }
        
        return $this->render('@Gestion/rrhh/altaConductor.html.twig', ['label' => 'Modificar', 'form' => $form->createView()]);
    }
}
