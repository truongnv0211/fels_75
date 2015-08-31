<?php

namespace ElearningBundle\Controller;

use ElearningBundle\Entity\Answer;
use ElearningBundle\Form\DoLessonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ElearningBundle\Entity\Category;
use ElearningBundle\Entity\Result;
use ElearningBundle\Entity\Lesson;
use ElearningBundle\Entity\Word;
use Symfony\Component\HttpFoundation\Request;

class LessonController extends Controller
{
    /**
     * @Route("/categories/{categoryId}/lesson/new", name="create_lesson")
     * @Method("POST")
     * @Template()
     */
    public function createAction(Request $request, $categoryId)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ElearningBundle:Category')->find($categoryId);
        $lessonLearned = $em->getRepository('ElearningBundle:Lesson')->getLessonLearned($this->getUser()->getId());
        $resultLearned = $em->getRepository('ElearningBundle:Result')->getResultFromLesson($lessonLearned);
        $words = $em->getRepository('ElearningBundle:Word')->getWordsForLesson($category, $resultLearned);

        if (count($words) >= $this->container->getParameter('word_per_lesson')) {
            $lesson = new Lesson();
            $lesson->setCategory($category);
            $lesson->setUser($user);
            shuffle($words);
            $words = array_slice($words, 0, $this->container->getParameter('word_per_lesson'));
            foreach ($words as $word) {
                $result = new Result();
                $result->setLesson($lesson);
                $result->setWord($word);
                $em->persist($result);
                $lesson->addResult($result);
            }
            $em->persist($lesson);
            $em->flush();
            $this->addFlash('success', 'Yay do lesson now !!!');

            return $this->redirectToRoute('do_lesson', ['lesson' => $lesson->getId()]);
        } else {
            $this->addFlash('danger', 'Sorry ! Not enough word to create lesson !!!');

            return $this->redirectToRoute('elearning_homepage');
        }
    }

    /**
     * @Route("/lesson/{lesson}/start", name="do_lesson")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function doAction (Request $request,Lesson $lesson)
    {
        $form = $this->createForm(new DoLessonType(), $lesson);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $data = $request->request->all();
            foreach ($data as $key => $value) {
                if (!is_array($key) and !is_array($value)) {
                    $em = $this->getDoctrine()->getManager();
                    $result = $em->getRepository('ElearningBundle:Result')->find($key);
                    $result->setAnswer($em->getRepository('ElearningBundle:Answer')->find($value));
                    $em->persist($result);
                    $em->flush();
                }
            }

            return $this->redirectToRoute('results_show', ['lesson' => $lesson->getId()]);
        }

        return ['lesson' => $lesson, 'form' => $form->createView()];
    }

    /**
     * @Route("/lesson/{lesson}/results", name="results_show")
     * @Method("GET")
     * @Template()
     */
    public function resultAction(Request $request, Lesson $lesson)
    {
        $results = $lesson->getResults();

        return ['lesson' => $lesson, 'results' => $results];
    }
}
