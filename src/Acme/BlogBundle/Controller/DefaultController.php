<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Acme\BlogBundle\Entity\Author;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $author = new Author();

        $author->setName("d");

        $author->gender = "d";

        $validator = $this->get("validator");
        $errors = $validator->validate($author,array("registration"));

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        return new Response('The author is valid! Yes!');
    }

    public function updateAction(Request $request)
    {

    //

    }

}
