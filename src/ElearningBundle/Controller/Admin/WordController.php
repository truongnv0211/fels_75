<?php

namespace ElearningBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use ElearningBundle\Entity\Word;
use ElearningBundle\Entity\Answer;
use ElearningBundle\Form\WordType;

/**
 * @Route("/admin/words")
 */
class WordController extends Controller
{
    /**
     * @Route("/", name="admin_word_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $words = $em->getRepository('ElearningBundle:Word')->createQueryBuilder('w');
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($words, $this->get('request')->get('page', 1), 10);

        return ['pagination' => $pagination];
    }

    /**
     * @Route("/new", name="new_admin_word")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $word = new Word();
        for ($i=0; $i < 4; $i++) {
            $word->addAnswer(new Answer());
        }
        $form = $this->createForm(new WordType(), $word);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $answers = $word->getAnswers();
            foreach ($answers as $answer) {
                $em->persist($answer);
            }
            $em->persist($word);
            $em->flush();
            $this->addFlash('success', 'Word create successfull !!!');

            return $this->redirectToRoute('admin_word_index');
        }

        return ['word' => $word, 'form' => $form->createView()];
    }

    /**
     * @Route("/{id}", name="show_admin_word")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $word = $em->getRepository('ElearningBundle:Word')->find($id);
        if (!$word) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        return ['word' => $word];
    }

    /**
     * @Route("/{id}/edit", name="edit_admin_word")
     * @Template()
     * @Method({"GET", "POST"})
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $word = $em->getRepository('ElearningBundle:Word')->find($id);
        if (!$word) {
            throw $this->createNotFoundException("No word found for id " . $id);
        }
        $form = $this->createForm(new WordType(), $word);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $answers = $word->getAnswers();
            foreach ($answers as $answer) {
                $em->persist($answer);
            }
            $em->persist($word);
            $em->flush();
            $this->addFlash('success', 'Word edit successfull !!!');

            return $this->redirectToRoute('admin_word_index');
        }

        return ['word' => $word, 'form' => $form->createView()];
    }

    /**
     * @Route("/{id}/delete", name="delete_admin_word")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $word = $em->getRepository('ElearningBundle:Word')->find($id);
        if (!$word) {
            throw $this->createNotFoundException("No word found for id " . $id);
        }
        $em = $this->getDoctrine()->getManager();
        foreach ($word.answers as $answer) {
            $em->remove($answer);
        }
        $em->remove($word);
        $em->flush();
        $this->addFlash('success', 'Word delete successfull !!!');

        return $this->redirectToRoute('admin_word_index');
    }
}
