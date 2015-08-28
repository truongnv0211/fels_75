<?php

namespace ElearningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ElearningBundle\Entity\Category;
use ElearningBundle\Entity\Result;
use ElearningBundle\Entity\Lesson;
use ElearningBundle\Entity\Word;

class LessonController extends Controller
{
    /**
     * @Route("/categories/{categoryId}/lesson/new", name="create_lesson")
     * @Template()
     */
    public function createAction($categoryId)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ElearningBundle:Category')->find($categoryId);
        if ($category->isEnoughWords()) {
            $lesson = new Lesson();
            $lesson->setCategory($category);
            $lesson->setUser($user);
            $words = $em->getRepository('ElearningBundle:Word')->getWordsForLesson($category, count($category->getWords()));
            foreach ($words as $word) {
                $result = new Result();
                $result->setLesson($lesson);
                $result->setWord($word);
                $em->persist($result);
            }
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('do_lesson');
        } else {
            $this->addFlash('danger', 'Not enough word to create lesson !!!');

            return $this->redirectToRoute('elearning_homepage');
        }
    }

    /**
     * @Route("/lesson/{id}/do", name="do_lesson")
     * @Template()
     */
    public function doAction($id)
    {

    }

}
