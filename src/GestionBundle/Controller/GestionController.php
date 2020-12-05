<?php

namespace GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GestionBundle\Form\ventas\CiudadType;
use GestionBundle\Entity\ventas\Ciudad;
use GestionBundle\Form\ventas\ClienteType;
use GestionBundle\Entity\ventas\Cliente;
use Symfony\Component\HttpFoundation\Request;

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
	                                'El cliente ha sido almacenada exitosamente!'
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
    	$form = $this->getFormAltaCliente($cliente, $route);	
    	$form->handleRequest($request);	
		if ($form->isValid())
		{    			
			$em->flush();
            $this->addFlash(
                                'success',
                                'El cliente ha sido modificada exitosamente!'
                            );
			return $this->redirectToRoute('listado_clientes');
		}
        return $this->render('@Gestion/ventas/altaCliente.html.twig', ['label' => 'Modificar', 'form' => $form->createView()]);
    }

}
