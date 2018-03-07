<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     *
     * @throws \LogicException
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();
        $groups = $em->getRepository('AppBundle:Usergroup')->findAll();

        return $this->render('default/index.html.twig', [
            'users' => $users,
            'groups' => $groups,
        ]);
    }
}
