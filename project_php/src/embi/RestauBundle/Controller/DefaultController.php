<?php

namespace embi\RestauBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@embiRestau/Default/index.html.twig');
    }

}
