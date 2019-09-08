<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\PostTypes;
use App\Form\UserMaterialsPublishType;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/materials")
 */
class UserMaterialsController extends AbstractController
{
    /**
     * @param PostsRepository $postsRepository
     * @return Response
     * @Route("/", name="materials_index", methods={"GET"})
     */
    public function index(PostsRepository $postsRepository): Response
    {
        $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
            'name' => 'Materijali'
        ]);
        $posts = $postsRepository->findBy([
            'user' => $this->getUser(),
            'type' => $type
        ]);
        return $this->render('user/materials/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="materials_new", methods={"GET","POST"})
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $post = new Posts();
        $form = $this->createForm(UserMaterialsPublishType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
                'name' => 'Materijali'
            ]);
            $date = new \DateTime();
            $post->setUser($this->getUser());
            $post->setType($type);
            $post->setDateUpdated($date);

            $fileData = $form['data']->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($fileData) {
                $originalFilename = pathinfo($fileData->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $fileData->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fileData->move(
                        $this->getParameter('materials_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return new JsonResponse([
                        'message' => $e
                    ]);
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setData($newFilename);

                $entityManager->persist($post);
                $entityManager->flush();

                return $this->redirectToRoute('materials_index');
            }
        }
        return $this->render('user/materials/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Posts $post
     * @return Response
     * @Route("/{id}", name="materials_show", methods={"GET"})
     */
    public function show(Posts $post): Response
    {
        return $this->render('user/materials/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @param Request $request
     * @param Posts $post
     * @return Response
     * @Route("/{id}/edit", name="materials_edit", methods={"GET","POST"})
     * @throws \Exception
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(UserMaterialsPublishType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
                'name' => 'Materijali'
            ]);
            $date = new \DateTime();
            $post->setUser($this->getUser());
            $post->setType($type);
            $post->setDateUpdated($date);

            $fileData = $form['data']->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($fileData) {
                $originalFilename = pathinfo($fileData->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $fileData->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fileData->move(
                        $this->getParameter('materials_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return new JsonResponse([
                        'message' => $e
                    ]);
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setData($newFilename);

                $entityManager->persist($post);
                $entityManager->flush();

                return $this->redirectToRoute('materials_index');
            }
        }

        return $this->render('user/materials/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Posts $post
     * @return Response
     * @Route("/{id}", name="materials_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Posts $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('materials_index');
    }
}
