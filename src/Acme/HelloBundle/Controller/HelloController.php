<?php

namespace Acme\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeHelloBundle:Hello:index.html.twig', array('name' => $name));

        //return new Response('<html><body>Hello '.$name.'</body></html>');
    }


    public function redirectAction($name, Request $request)
    {
        //return $this->redirect("http://www.".$name.".pl");

        $response = new Response(json_encode(array("name"=>$name)));
        $response->headers->set("Content-Type","application/json");

        return $response;

        //return new Response('<html><body>Hello '.$name.'</body></html>');
    }

}
