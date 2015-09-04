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
        if ($user) {
            $em = $this->getDoctrine()->getManager();
            $followees = $em->getRepository('ElearningBundle:Relationship')->getFolloweeIds($user);
            $activities = $em->getRepository('ElearningBundle:Lesson')->getActivityForUser($user, $followees);
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate($activities, $this->get('request')->get('page', 1), $this->container->getParameter('activities_per_page'));

            return ['activities' => $pagination];
        } else {
            return [];
        }
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
