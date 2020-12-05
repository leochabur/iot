<?php
namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserAuthenticator extends AbstractGuardAuthenticator
{
    private $security = null, $logger = null, $em = null, $router = null, $passwordEncoder = null;

    public function __construct(EntityManager $em, RouterInterface $router, LoggerInterface $logger, UserPasswordEncoderInterface $passwordEncoder, Security $security)
    {
        $this->logger = $logger;
        $this->router = $router;
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->security = $security;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        return (($request->attributes->get('_route') === 'login_usuario') && ($request->isMethod('POST')));
    }


    public function getCredentials(Request $request)
    {
        if (($request->attributes->get('_route') != 'login_usuario')|| (!$request->isMethod('POST')))
        {
            return;
        }

        $token = [
                    'username' => $request->request->get('_username'),
                    'password' => $request->request->get('_password'),
                    'company'   => $request->request->get('_codigoEmpresa'),
                ];
        return $token;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $credentials;

        if (!$token['username']) {
            throw new CustomUserMessageAuthenticationException(
                'El campo usuario es obligatorio'
            );
        }
        if (!$token['password']) {
            throw new CustomUserMessageAuthenticationException(
                'Debe introducir una contraseña'
            );
        }

        $repository = $this->em->getRepository('AppBundle:Usuario');
        if (!$token['company'])//no se ha cargado el codigo de la compañia, debe buscar si el usuario es el Role Generador del sistema
        {
            try
            {
                $user = $repository->getUserAdministrador($token['username']);
                if ($user)
                {
                    return $user;
                }
                throw new CustomUserMessageAuthenticationException(
                                                                    'Usuario inexistente en la Base de Datos'
                                                                    );    
            }
            catch(\Exception $e){
                throw new CustomUserMessageAuthenticationException(
                                                                    'No se pudo recuperar el usuario'.$e->getMessage()
                                                                    );    
            }
        }

        $company = $this->em->getRepository('AppBundle:Empresa')->getEmpresaWithCodigo($token['company']);

        try
        {
            $user = $repository->getUserWithCompany($token['username'], $company);
            if ($user)
            {
                return $user;
            }
            throw new CustomUserMessageAuthenticationException(
                                                                'Usuario inexistente en la Base de Datos'
                                                                );    
        }
        catch(\Exception $e){
            throw new CustomUserMessageAuthenticationException(
                                                                'No se pudo recuperar el usuario '
                                                                );    
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {

        $validPassword = $this->passwordEncoder->isPasswordValid(
                                                                    $user, // the encoded password
                                                                    $credentials['password'],       // the submitted password
                                                                    $user->getSalt()
                                                                );
        if  ($validPassword)
            return true;



        throw new CustomUserMessageAuthenticationException('No se pudo recuperar el usuario');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $user = $token->getUser();
        if ($this->security->isGranted('ROLE_CREATOR')) 
        {
                    //deberia redirigir al sitio para crear
        }
        $url = $this->router->generate('homepage');
        return new RedirectResponse($url);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {

            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $this->router->generate('login_usuario');
        return new RedirectResponse($url);
    }

    public function supportsRememberMe()
    {
        return true;
    }
}