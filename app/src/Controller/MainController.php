<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController.
 */
#[\Symfony\Component\Routing\Attribute\Route('/')]
class MainController extends AbstractController
{
    /**
     * Index action.
     *
     * @return Response HTTP response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/', name: 'main_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }
}
