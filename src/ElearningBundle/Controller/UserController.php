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
     * @Route("/profile", name="user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction()
    {
        return ['user' => $this->getUser()];
    }

    /**
     * @Route("/edit", name="user_edit")
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
}
