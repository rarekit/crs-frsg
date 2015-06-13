<?php

namespace Crous\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrousBackendBundle:Default:index.html.twig', array('name' => $name));
    }
}
