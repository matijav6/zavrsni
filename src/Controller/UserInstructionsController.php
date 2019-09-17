<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\PostTypes;
use App\Form\UserPublishType;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/instructions")
 */
class UserInstructionsController extends AbstractController
{
    /**
     * @param PostsRepository $postsRepository
     * @return Response
     * @Route("/", name="instructions_index", methods={"GET"})
     */
    public function index(PostsRepository $postsRepository): Response
    {
        $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
            'name' => 'Instrukcije'
        ]);
        $posts = $postsRepository->findBy([
            'user' => $this->getUser(),
            'type' => $type
        ]);
        return $this->render('user/instructions/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="instructions_new", methods={"GET","POST"})
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $post = new Posts();
        $post->setUser($this->getUser());
        $form = $this->createForm(UserPublishType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
                'name' => 'Instrukcije'
            ]);
            $date = new \DateTime();
            $entityManager->persist($post);
            $post->setUser($this->getUser());
            $post->setType($type);
            $post->setDateUpdated($date);
            $entityManager->flush();

            return $this->redirectToRoute('instructions_index');
        }

        return $this->render('user/instructions/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Posts $post
     * @return Response
     * @Route("/{id}", name="instructions_show", methods={"GET"})
     */
    public function show(Posts $post): Response
    {
        return $this->render('user/instructions/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @param Request $request
     * @param Posts $post
     * @return Response
     * @Route("/{id}/edit", name="instructions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(UserPublishType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('instructions_index');
        }

        return $this->render('user/instructions/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Posts $post
     * @return Response
     * @Route("/{id}", name="instructions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Posts $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('instructions_index');
    }
}
