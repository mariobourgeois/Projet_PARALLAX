<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\MiseEnAvantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AutomobileController extends AbstractController
{
    /**
     * @Route("/automobile", name="automobile")
     */

    public function index(ArticleRepository $articleRepo): Response
    {
        $articles = $articleRepo->findByIdMiseEnAvant(null);
        $misesenavant = $articleRepo->findByIdMiseEnAvant(1);

        return $this->render('automobile/automobile.html.twig', [
            'articles' => $articles,
            'misesenavant' => $misesenavant,
        ]);
    }
}

