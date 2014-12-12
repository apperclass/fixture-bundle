<?php

namespace Apperclass\Bundle\FixtureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ApperclassFixtureBundle:Default:index.html.twig', array('name' => $name));
    }
}
