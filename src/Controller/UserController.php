<?php


namespace App\Controller;

use App\Entity\Posts;
use App\Entity\PostTypes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/dashboard")
 */
class UserController extends AbstractController
{
    /**
     * @return Response
     * @Route(path="/news", name="user.news")
     */
    public function getNews()
    {
        $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
            'name' => "Novosti"
        ]);
        $posts = $this->getDoctrine()->getRepository(Posts::class)->findBy([
            'type' => $type
        ]);
        return $this->render('user/dashboard.html.twig', [
            'posts' => $posts,
            'file' => false
        ]);
    }

    /**
     * @return Response
     * @Route(path="/instructions", name="user.instructions")
     */
    public function getInstructions()
    {
        $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
            'name' => "Instrukcije"
        ]);
        $posts = $this->getDoctrine()->getRepository(Posts::class)->findBy([
            'type' => $type
        ]);
        return $this->render('user/dashboard.html.twig', [
            'posts' => $posts,
            'file' => false
        ]);
    }

    /**
     * @return Response
     * @Route(path="/materials", name="user.materials")
     */
    public function getMaterials()
    {
        $type = $this->getDoctrine()->getRepository(PostTypes::class)->findOneBy([
            'name' => "Materijali"
        ]);
        $posts = $this->getDoctrine()->getRepository(Posts::class)->findBy([
            'type' => $type
        ]);
        return $this->render('user/dashboard.html.twig', [
            'posts' => $posts,
            'file' => true
        ]);
    }
}