<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @return Response
     * @Route(path="/dashboard", name="user.dashboard")
     */
    public function getDashboard()
    {
        return $this->render('user/dashboard.html.twig');
    }
}