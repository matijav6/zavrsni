<?php

namespace App\Controller;

use App\Entity\PostTypes;
use App\Form\PostTypesType;
use App\Repository\PostTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/post/types")
 */
class PostTypesController extends AbstractController
{
    /**
     * @param PostTypesRepository $postTypesRepository
     * @return Response
     * @Route("/", name="post_types_index", methods={"GET"})
     */
    public function index(PostTypesRepository $postTypesRepository): Response
    {
        return $this->render('post_types/index.html.twig', [
            'post_types' => $postTypesRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="post_types_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $postType = new PostTypes();
        $form = $this->createForm(PostTypesType::class, $postType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($postType);
            $entityManager->flush();

            return $this->redirectToRoute('post_types_index');
        }

        return $this->render('post_types/new.html.twig', [
            'post_type' => $postType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param PostTypes $postType
     * @return Response
     * @Route("/{id}", name="post_types_show", methods={"GET"})
     */
    public function show(PostTypes $postType): Response
    {
        return $this->render('post_types/show.html.twig', [
            'post_type' => $postType,
        ]);
    }

    /**
     * @param Request $request
     * @param PostTypes $postType
     * @return Response
     * @Route("/{id}/edit", name="post_types_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PostTypes $postType): Response
    {
        $form = $this->createForm(PostTypesType::class, $postType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_types_index');
        }

        return $this->render('post_types/edit.html.twig', [
            'post_type' => $postType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param PostTypes $postType
     * @return Response
     * @Route("/{id}", name="post_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PostTypes $postType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($postType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_types_index');
    }
}
