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
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $followee  = $em->getRepository('ElearningBundle:Relationship')->getFolloweeIds($user);
        $activities  = $em->getRepository('ElearningBundle:Lesson')->getActivityForUser($user, $followee);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($activities, $this->get('request')->get('page', 1), $this->container->getParameter('activities_per_page'));

        return ['activities' => $pagination];
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
