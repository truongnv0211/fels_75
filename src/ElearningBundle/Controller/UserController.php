<?php

namespace ElearningBundle\Controller;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;
use ElearningBundle\Entity\User;
use ElearningBundle\Form\UserType;
use ElearningBundle\Form\UserProfileType;
use ElearningBundle\Entity\Relationship;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     * @Template()
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('danger', 'You have already login!!');
            return $this->redirectToRoute('elearning_homepage');
        }

        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->addFlash('success', 'The registration was successful');

            return $this->redirectToRoute('elearning_homepage');
        }

        return ['form' => $form->createView(), 'user' => $user];
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/users", name="user_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('ElearningBundle:User')->createQueryBuilder('u');
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($users, $this->get('request')->get('page', 1), $this->container->getParameter('users_per_page'));
        $followee_ids = $em->getRepository('ElearningBundle:Relationship')->getFolloweeIds($this->getUser());
        $followee_ids = $followee_ids != NULL ? call_user_func_array('array_merge', $followee_ids) : "";

        return ['users' => $pagination, 'followee_ids' => $followee_ids];
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/user/{id}/profile", name="user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ElearningBundle:User')->find($id);
        $follow = $em->getRepository('ElearningBundle:Relationship')->findOneBy(['follower' => $this->getUser()->getId(), 'followee' => $id]);
        $activities  = $em->getRepository('ElearningBundle:Lesson')->getActivityForUser($user);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($activities, $this->get('request')->get('page', 1), $this->container->getParameter('activities_per_page'));

        return ['user' => $user, 'follow' => $follow, 'activities' => $pagination];
    }

    /**
     * @Route("/user/edit", name="user_edit")
     * @Template()
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new UserProfileType(), $user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $em = $this->getDoctrine()->getManager();
            $password = $encoder->encodePassword($user->getNewPassword(), $user->getSalt());
            $user->setPassword($password);
            $user->setName($user->getName());
            $user->setEmail($user->getEmail());
            $em->persist($user);
            $em->flush();
            $em->refresh($user);
            $this->addFlash('success', 'The profile was successfully updated');

            return $this->redirectToRoute('user_show');
        }

        return ['form' => $form->createView(), 'user' => $user];
    }

    /**
     * FollowAction
     *
     * @Route("/user/follow/{followee_id}", name="follow")
     * @Template()
     * @Method({"POST"})
     */
    public function followAction(Request $request, $followee_id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ElearningBundle:User')->find($followee_id);
        $relationship = new Relationship();
        $relationship->setFollowee($user);
        $relationship->setFollower($this->getUser());
        $em->persist($relationship);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            $json = json_encode([
                'followee_id' => $followee_id,
            ]);
            $response = new Response($json);
            $response->headers->set('Content-Type','appication/json');

            return $response;
        }
    }

    /**
     * FollowAction
     *
     * @Route("/user/unfollow/{followee_id}", name="unfollow")
     * @Template()
     * @Method({"POST"})
     */
    public function unFollowAction(Request $request, $followee_id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ElearningBundle:User')->find($followee_id);
        $relationship = $em->getRepository('ElearningBundle:Relationship')->findOneBy([
            'follower' => $this->getUser()->getId(),
            'followee' => $user->getId()
        ]);
        $em->remove($relationship);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            $json = json_encode([
                'followee_id' => $followee_id,
            ]);
            $response = new Response($json);
            $response->headers->set('Content-Type','appication/json');

            return $response;
        }
    }
}
