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
        $csrf = $this->get('form.csrf_provider');
        $token = $csrf->generateCsrfToken('region');

        $regions = $this->get('manager_factory')->create('region')->getRegions();
        return $this->render('CrousBackendBundle:Default:flux-dashboard.html.twig', array(
                    'regions' => $regions,
                    'token'   => $token
        ));
    }

}
