<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usergroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Form\UsergroupType;

/**
 * Usergroup controller.
 *
 * @Route("group")
 */
class UsergroupController extends Controller
{
    /**
     * Creates a new usergroup entity.
     *
     * @Route("/new", name="group_new")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws \LogicException
     */
    public function newAction(Request $request)
    {
        $usergroup = new Usergroup();
        $form = $this->createForm(UsergroupType::class, $usergroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usergroup);
            $em->flush();

            return $this->redirectToRoute('homepage', ['id' => $usergroup->getId()]);
        }

        return $this->render('default/edit.html.twig', [
            'title' => 'Create a new group',
            'usergroup' => $usergroup,
            'edit_form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing usergroup entity.
     *
     * @Route("/{id}/edit", name="group_edit")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Usergroup $usergroup
     *
     * @return RedirectResponse|Response
     *
     * @throws \LogicException
     */
    public function editAction(Request $request, Usergroup $usergroup)
    {
        $editForm = $this->createForm(UsergroupType::class, $usergroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage', ['id' => $usergroup->getId()]);
        }

        return $this->render('default/edit.html.twig', [
            'title' => 'Edit group #' . $usergroup->getId(),
            'usergroup' => $usergroup,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a usergroup entity.
     *
     * @Route("/{id}", name="group_delete")
     *
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Usergroup $usergroup
     *
     * @return JsonResponse|RedirectResponse
     *
     * @throws \LogicException
     * @throws AccessDeniedException
     */
    public function deleteAction(Request $request, Usergroup $usergroup)
    {
        if (!$this->isCsrfTokenValid($usergroup->getId(), $request->get('_token'))) {
            throw $this->createAccessDeniedException('CSRF token is not valid');
        }

        if (!$usergroup->getUsers()->isEmpty()) {
            return new JsonResponse([
                'message' => 'You can delete groups only when they no longer have members.',
                'success' => false
            ], 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($usergroup);
        $em->flush();

        return new JsonResponse([
            'message' => 'Success!',
            'success' => true
        ], 200);
    }
}
