<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number MEGA: '.$number.'</body></html>'
        );
    }

    #[Route("/lucky/hi")]
    public function hiResponse(): Response
    {
        return new Response(
            '<html><body>Hi to MEGA you!</body></html>'
        );
    }
}
