<?php

namespace Crous\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    /**
     * indexAction
     * 
     * @access public
     * @return Response
     */
    public function indexAction($name)
    {
        return $this->render('CrousBackendBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     *  loginAction
     *
     *  @access public
     *  @return Response
     */
    public function loginAction() {
        $request = $this->getRequest ();
        $session = $request->getSession ();
        if ($request->attributes->has (SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get (SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get (SecurityContext::AUTHENTICATION_ERROR);
            $session->remove (SecurityContext::AUTHENTICATION_ERROR);
        }   
           
        return $this->render('CrousBackendBundle:Security:login.html.twig', array ( 
            'last_username' => $session->get (SecurityContext::LAST_USERNAME), 
            'error' => $error 
        ));
    }

}
