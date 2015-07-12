<?php

namespace Crous\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Crous\Bundle\BackendBundle\Form\Type\PushType;

class PushController extends Controller
{

    public function indexAction()
    {
        $form = $this->createForm(new PushType());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $data = $form->getData();

                $apiUrl = $this->container->getParameter('push_url');
                $apiKey = $this->container->getParameter('push_api_key');
                $apiSecret = $this->container->getParameter('push_shared_secret');
                $apiAppName = $this->container->getParameter('push_appname');
                $apiProject = $this->container->getParameter('push_project');

                $requestVars = array();
                $requestVars['project'] = $apiProject;
                $requestVars['message'] = $data['message'];
                $requestVars['dkGroup'] = 'general';
                $requestVars['dks'] = $data['region']->getName();
                $requestVars['title'] = $data['title'];
                
                $arg = $apiSecret;
                foreach ($requestVars as $key=>$value) {
                    $arg = $arg.$key.$value;   
                }

                $apiSig = md5($arg);
                $requestVars['api_sig'] = urlencode($apiSig);
                $requestVars['api_key'] = urlencode($apiKey);
                $result = $this->callApi('GET', $apiUrl, $requestVars);
                $xmlResult = simplexml_load_string($result);
                if (isset($xmlResult->error->message)) {
                    $this->addFlash('error', $xmlResult->error->message);
                } else {
                    $this->addFlash('success', $this->get('translator')->trans('Send successful'));
                }
            }
        }
        return $this->render('CrousBackendBundle:Push:index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    protected function callApi($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

}   
