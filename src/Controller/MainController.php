<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @return RedirectResponse
     * @Route(path="/", name="index")
     */
    public function getIndex()
    {
        return $this->redirectToRoute('login');
    }
}