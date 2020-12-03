<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use AppBundle\Entity\Empresa;
use AppBundle\Form\EmpresaType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/administrar")
 */

class DefaultController extends Controller
{
    /**
     * @Route("/usuarios/registrar", name="registro_usuario")
     */
    public function registroUsuarioAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $password = $passwordEncoder->encodePassword($usuario, $usuario->getPlainPassword());
            $usuario->setPassword($password);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $usuario->setRoles(['ROLE_USER']);
            $entityManager->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render(
            'usuario/registro.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/empresas/registrar", name="registro_empresa")
     */
    public function registroEmpresaAction(Request $request)
    {
        $empresa = new Empresa();
        $form = $this->createForm(EmpresaType::class, $empresa);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($empresa);

            $entityManager->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render(
            'empresa/registro.html.twig',
            ['form' => $form->createView()]
        );
    }
}
