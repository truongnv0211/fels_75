<?php

namespace ElearningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ElearningBundle\Form\FilterType;

class WordController extends Controller
{
    /**
     * @Route("/words/filter", name="wordlist_filter")
     * @Template()
     * @Method({"GET"})
     */
    public function filterAction(Request $request)
    {
        $form = $this->createForm(new FilterType());
        $form->handleRequest($request);
        $data = $request->query->get('elearning_word_filter');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $lessons = $user->getLessons();
        $wordsInResult = $em->getRepository('ElearningBundle:Result')->getResultFromLesson($lessons->toArray());
        switch ($data['type_word']) {
            case 'learned':
                $words = $em->getRepository('ElearningBundle:Word')->getLearnedWord($data['category'], $wordsInResult);
                break;
            case 'not_learned':
                $words = $em->getRepository('ElearningBundle:Word')->getNotLearnedWord($data['category'], $wordsInResult);
                break;
            default:
                $words = $em->getRepository('ElearningBundle:Word')->getWordsByCategory($data['category']);
                break;
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($words, $this->get('request')->get('page', 1), $this->container->getParameter('words_per_page'));
        return ['form' => $form->createView(), 'words' => $pagination];
    }

}
