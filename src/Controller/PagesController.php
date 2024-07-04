<?php

namespace App\Controller;

use App\Entity;
use App\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PagesController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Repository\PageRepository $pageRepository): Response
    {
        $pages = $pageRepository->findAll();
        return $this->render('pages/index.html.twig', [
            'pages' => $pages,
        ]);
    }

    #[Route('/pages/{slug}', name: 'page')]
    public function show(Entity\Page $page): Response
    {
        return $this->render('pages/show.html.twig', [
            'page' => $page,
        ]);
    }
}
