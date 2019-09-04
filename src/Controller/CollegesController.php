<?php

namespace App\Controller;

use App\Entity\Colleges;
use App\Form\CollegesType;
use App\Repository\CollegesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/colleges")
 */
class CollegesController extends AbstractController
{
    /**
     * @param CollegesRepository $collegesRepository
     * @return Response
     * @Route("/", name="colleges_index", methods={"GET"})
     */
    public function index(CollegesRepository $collegesRepository): Response
    {
        return $this->render('colleges/index.html.twig', [
            'colleges' => $collegesRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="colleges_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $college = new Colleges();
        $form = $this->createForm(CollegesType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($college);
            $entityManager->flush();

            return $this->redirectToRoute('colleges_index');
        }

        return $this->render('colleges/new.html.twig', [
            'college' => $college,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Colleges $college
     * @return Response
     * @Route("/{id}", name="colleges_show", methods={"GET"})
     */
    public function show(Colleges $college): Response
    {
        return $this->render('colleges/show.html.twig', [
            'college' => $college,
        ]);
    }

    /**
     * @param Request $request
     * @param Colleges $college
     * @return Response
     * @Route("/{id}/edit", name="colleges_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Colleges $college): Response
    {
        $form = $this->createForm(CollegesType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('colleges_index');
        }

        return $this->render('colleges/edit.html.twig', [
            'college' => $college,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Colleges $college
     * @return Response
     * @Route("/{id}", name="colleges_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Colleges $college): Response
    {
        if ($this->isCsrfTokenValid('delete'.$college->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($college);
            $entityManager->flush();
        }

        return $this->redirectToRoute('colleges_index');
    }
}
