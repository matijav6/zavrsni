<?php

namespace App\Controller;

use App\Entity\County;
use App\Form\CountyType;
use App\Repository\CountyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/county")
 */
class CountyController extends AbstractController
{
    /**
     * @param CountyRepository $countyRepository
     * @return Response
     * @Route("/", name="county_index", methods={"GET"})
     */
    public function index(CountyRepository $countyRepository): Response
    {
        return $this->render('county/index.html.twig', [
            'counties' => $countyRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="county_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $county = new County();
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($county);
            $entityManager->flush();

            return $this->redirectToRoute('county_index');
        }

        return $this->render('county/new.html.twig', [
            'county' => $county,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param County $county
     * @return Response
     * @Route("/{id}", name="county_show", methods={"GET"})
     */
    public function show(County $county): Response
    {
        return $this->render('county/show.html.twig', [
            'county' => $county,
        ]);
    }

    /**
     * @param Request $request
     * @param County $county
     * @return Response
     * @Route("/{id}/edit", name="county_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, County $county): Response
    {
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('county_index');
        }

        return $this->render('county/edit.html.twig', [
            'county' => $county,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param County $county
     * @return Response
     * @Route("/{id}", name="county_delete", methods={"DELETE"})
     */
    public function delete(Request $request, County $county): Response
    {
        if ($this->isCsrfTokenValid('delete'.$county->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($county);
            $entityManager->flush();
        }

        return $this->redirectToRoute('county_index');
    }
}
