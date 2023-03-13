<?php

namespace App\Controller;

use App\Http\Response\StarWarsResponse;
use App\Service\HttpClient;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route('/', name: 'app_starships_dashboard')]
    public function index(): Response
    {

        $response = $this->httpClient->getStarshipsCollection();

        $starships = $this->buildFullCollection($response);

        return $this->render('dashboard.html.twig', [
            'starships_collection' => $starships,
        ]);
    }

    private function buildFullCollection(StarWarsResponse $response) : array
    {
        $collection = $response->getResponseContent()['results'] ?? [];

        while(($next = $response->getResponseContent()['next']) != null)
        {
            $response = ($this->httpClient->getNextPage($next));

            $next = $response->getResponseContent()['next'];

            $collection = array_merge($collection, $response->getResponseContent()['results'] ?? []);
        }

        return $collection;
    }
}
