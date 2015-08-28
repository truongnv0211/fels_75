<?php

namespace ElearningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="category_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ElearningBundle:Category')->createQueryBuilder('c');
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($categories, $this->get('request')->get('page', 1), $this->container->getParameter('categories_per_page'));

        return ['pagination' => $pagination];
    }

}
