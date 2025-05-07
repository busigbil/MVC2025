<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ApiJson extends AbstractController
{
    #[Route("/api", name: 'json_routes')]
    public function jsonRoutes(
        RouterInterface $router,
        Request $request
    ): Response
    {
        //som visar en webbsida med en sammanställning av alla JSON routes 
        // som din webbplats erbjuder. Varje route skall ha en förklaring 
        // vad den gör.

        //Get all routes.
        $routes = $router->getRouteCollection()->all();
        $apiArr = array();

        //Add route to array if starts with api.
        foreach ($routes as $route) {

            if (str_starts_with($route->getPath(), '/api/')) {
                $description = $route->getDefault('description') ?? 'Beskrivning saknas';

                $apiArr[] = [
                    'header' => $route->getPath(),
                    'description' => $description
                ];
            }
        }

        $data = [
            'routes' => $apiArr
        ];
        return $this->render('api.html.twig', $data);
    }

    #[Route("/api/quote", defaults: ['description' => 'Väljer ett citat från en lista och returnerar det med tiddatum stämpel.'])]
    public function jsonQuote(): Response
    {
        //Create quote and date.
        $quoteArr = array(
            'Människan är alltings mått. - Protagoras',
            'Att lära många ting lär oss inte att förstå. - Herakleitos',
            'Svin njuter av gyttja mer än rent vatten. - Herakleitos',
            'Den som vill försöka bli lycklig skall inte lägga an på att öka sina tillgångar utan på att begränsa sina krav. - Platon',
            'En god och ädel man bör avhålla sig från varje som helst kontakt med arbetslivet. - Platon',
            'Om jag ändå kunde finna sanningen lika lätt som jag kan avslöja osanningen. - Cicero'
        );

        $index = random_int(0, count($quoteArr) - 1);

        date_default_timezone_set("Europe/Stockholm");
        $dateTime = date("Y-m-d H:i:s", time());

        //Add quote and date for json response.
        $data = [
            'today-quote' => $quoteArr[$index],
            'today-date' => $dateTime
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
