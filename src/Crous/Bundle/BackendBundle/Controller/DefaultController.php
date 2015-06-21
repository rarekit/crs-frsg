<?php

namespace Crous\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CrousBackendBundle:Default:index.html.twig');
    }
    
    public function fluxDashboardAction()
    {
        return $this->render('CrousBackendBundle:Default:flux-dashboard.html.twig');
    }
}
