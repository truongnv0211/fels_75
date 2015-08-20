<?php

namespace ElearningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;
use ElearningBundle\Entity\User;
use ElearningBundle\Form\UserType;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     * @Template()
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
      $user = new User();
      $form = $this->createForm(new UserType(), $user);
      $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
          $user = $form->getData();
          $encoder = $this->container->get('security.password_encoder');
          $password = $encoder->encodePassword($user, $user->getPassword());
          $user->setPassword($password);
          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();
          $this->addFlash('notice', 'The registration was successful');
          return $this->redirect($this->generateUrl('user_registration'));
        }
      return ['form' => $form->createView(), 'user' => $user];
    }
}
