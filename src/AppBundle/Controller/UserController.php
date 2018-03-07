<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     *
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws \LogicException
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage', ['id' => $user->getId()]);
        }

        return $this->render('default/edit.html.twig', [
            'title' => 'Create a new user',
            'user' => $user,
            'edit_form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse|Response
     *
     * @throws \LogicException
     */
    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm(UserType::class, $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage', ['id' => $user->getId()]);
        }

        return $this->render('default/edit.html.twig', [
            'title' => 'Edit user #' . $user->getId(),
            'user' => $user,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     *
     * @Method("DELETE")
     *
     * @param Request $request
     * @param User $user
     *
     * @return JsonResponse|RedirectResponse
     *
     * @throws \LogicException
     * @throws AccessDeniedException
     */
    public function deleteAction(Request $request, User $user)
    {
        if (!$this->isCsrfTokenValid($user->getId(), $request->get('_token'))) {
            throw $this->createAccessDeniedException('CSRF token is not valid');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new JsonResponse([
            'message' => 'Success!',
            'success' => true
        ], 200);
    }
}
