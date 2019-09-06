<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\PostTypes;
use App\Form\PostsType;
use App\Form\UserNewsType;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/news")
 */
class UserNewsController extends AbstractController
{
    /**
     * @param PostsRepository $postsRepository
     * @return Response
     * @Route("/", name="news_index", methods={"GET"})
     */
    public function index(PostsRepository $postsRepository): Response
    {
        $posts = $postsRepository->findBy([
            'user' => $this->getUser()
        ]);
        return $this->render('user/news/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="news_new", methods={"GET","POST"})
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $post = new Posts();
        $form = $this->createForm(UserNewsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
                'name' => 'Novosti'
            ]);
            $date = new \DateTime();
            $entityManager->persist($post);
            $post->setUser($this->getUser());
            $post->setType($type);
            $post->setDateUpdated($date);
            $entityManager->flush();

            return $this->redirectToRoute('news_index');
        }

        return $this->render('user/news/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Posts $post
     * @return Response
     * @Route("/{id}", name="news_show", methods={"GET"})
     */
    public function show(Posts $post): Response
    {
        return $this->render('user/news/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @param Request $request
     * @param Posts $post
     * @return Response
     * @Route("/{id}/edit", name="news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(UserNewsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('news_index');
        }

        return $this->render('user/news/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Posts $post
     * @return Response
     * @Route("/{id}", name="news_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Posts $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news_index');
    }
}
