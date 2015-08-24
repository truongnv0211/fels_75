<?php

namespace ElearningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class StaticPageController extends Controller
{
    /**
     * @Route("/", name="elearning_homepage")
     * @Template
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/about", name="about_page")
     * @Template
     * @Method("GET")
     */
    public function aboutAction()
    {
        return [];
    }
}
