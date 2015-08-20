<?php

namespace ElearningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login_form")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');
        return ['last_username' => $helper->getLastUsername(), 'error' => $helper->getLastAuthenticationError()];
    }

    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
    }

}
