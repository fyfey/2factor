<?php

namespace Enable\TextLocalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EnableTextLocalBundle:Default:index.html.twig', array('name' => $name));
    }
}
