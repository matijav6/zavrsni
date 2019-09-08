<?php


namespace App\Controller;

use App\Entity\Posts;
use App\Entity\PostsLikesDislikes;
use App\Entity\PostTypes;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $posts = $this->getDoctrine()->getRepository(User::class)->getPostsForUser($this->getUser(), 'Novosti');
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
        $posts = $this->getDoctrine()->getRepository(User::class)->getPostsForUser($this->getUser(), 'Instrukcije');
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
        $posts = $this->getDoctrine()->getRepository(User::class)->getPostsForUser($this->getUser(), 'Materijali');
        return $this->render('user/dashboard.html.twig', [
            'posts' => $posts,
            'file' => true
        ]);
    }

    /**
     * @param Request $request
     * @Route(path="/useful", name="user.post.useful")
     * @return Response
     */
    public function useful(Request $request)
    {
        $postId = json_decode($request->getContent())->post_id;
        $post = $this->getDoctrine()->getRepository(Posts::class)->findOneBy([
            'id' => $postId
        ]);
        $likesDislikes = $post->getLikesDislikes();
        if (!$likesDislikes) {
            $likesDislikes = new PostsLikesDislikes();
            $likes = 0;
            $dislikes = 0;
        } else {
            $likes = $likesDislikes->getLikes();
            $dislikes = $likesDislikes->getDislikes();
        }

        if (!$likesDislikes->getUsers()->contains($this->getUser())) {
            $likesDislikes->addUser($this->getUser());
            $likesDislikes->setLikes($likes + 1);
        } else {
            return new JsonResponse([
                'code' => 403
            ]);
        }
        $likesDislikes->setDislikes($dislikes);
        $post->setLikesDislikes($likesDislikes);
        $this->getDoctrine()->getRepository(Posts::class)->savePost($post);
        return new JsonResponse([
            'code' => 200
        ]);
    }

    /**
     * @param Request $request
     * @Route(path="/notUseful", name="user.post.notUseful")
     * @return Response
     */
    public function notUseful(Request $request)
    {
        $postId = json_decode($request->getContent())->post_id;
        $post = $this->getDoctrine()->getRepository(Posts::class)->findOneBy([
            'id' => $postId
        ]);
        $likesDislikes = $post->getLikesDislikes();
        if (!$likesDislikes) {
            $likesDislikes = new PostsLikesDislikes();
            $likes = 0;
            $dislikes = 0;
        } else {
            $likes = $likesDislikes->getLikes();
            $dislikes = $likesDislikes->getDislikes();
        }

        if (!$likesDislikes->getUsers()->contains($this->getUser())) {
            $likesDislikes->addUser($this->getUser());
            $likesDislikes->setDislikes($dislikes + 1);
        } else {
            return new JsonResponse([
                'code' => 403
            ]);
        }
        $likesDislikes->setLikes($likes);
        $post->setLikesDislikes($likesDislikes);
        $this->getDoctrine()->getRepository(Posts::class)->savePost($post);
        return new JsonResponse([
            'code' => 200
        ]);
    }
}