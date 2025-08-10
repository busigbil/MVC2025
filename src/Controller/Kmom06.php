<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Kmom06 extends AbstractController
{
    #[Route("/metrics", name: "metrics")]
    public function metrics(): Response
    {
        //Skapa en landningssida metrics/ för din “Metrics analys”
        // som handlar om kodkvalitet och hur man kan jobba med “Clean code”.
        // Placera landningssidan i din navbar. Du skriver din rapport direkt i landningssidan.
        return $this->render('metrics.html.twig');
    }
}
