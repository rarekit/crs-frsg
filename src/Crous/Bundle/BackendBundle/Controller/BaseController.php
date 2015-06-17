<?php

namespace Crous\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function addMessage($type, $message)
    {
        $this->addFlash($type, $this->get('translator')->trans($message));
    }
    
    public function createPagination($total, $current)
    {
        $perPage = $this->container->getParameter('item_per_page');
        $lastPage = ceil($total / $perPage);
        $previousPage = $current > 1 ? $current - 1 : 1;
        $nextPage = $current < $lastPage ? $current + 1 : $lastPage;
    
        return $this->renderView('CrousBackendBundle:Block:pagination.html.twig', array(
            'lastPage' => $lastPage,
            'previousPage' => $previousPage,
            'currentPage' => $current,
            'nextPage' => $nextPage,
            'total' => $total
        ));
    }
}
