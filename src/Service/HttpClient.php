<?php

namespace App\Service;

use App\Enum\SwApiEnum;
use App\Http\Exception\ResponseNotSuccessfulException;
use App\Http\Response\StarWarsResponse;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class HttpClient
{
    private const COLLECTION = '%s/?page=%u';
    private const SINGLE_RECORD = '%s/%u/';
    /**
     * @var Client
     */
    private $httpClient;

    public function __construct(string $baseUri)
    {
        $this->httpClient = $this->createHttpClient($baseUri);
    }

    public function createHttpClient(string $baseUri, ?LoggerInterface $logger = null)
    {
        $handlerStack = HandlerStack::create();

        if($logger != null) {
            $handlerStack->push(
                Middleware::log($logger, new MessageFormatter('HTTP Client - Request: {request} - Response: {response} - Error: {error}'))
            );
        }

        return new Client([
            'base_uri' => $baseUri,
            'handler' => $handlerStack,
        ]);
    }

    private function genericRequest(ResponseInterface $response)
    {
        if (200 !== $response->getStatusCode()) {
            throw new ResponseNotSuccessfulException($response);
        }

        return new StarWarsResponse($response);
    }

    public function getStarshipsCollection(int $page=1)
    {
        $response = $this->httpClient->get(sprintf(self::COLLECTION, SwApiEnum::STARSHIPS, $page));

        return $this->genericRequest($response);
    }

    public function getStarships(int $index)
    {
        $response = $this->httpClient->get(sprintf(self::SINGLE_RECORD, SwApiEnum::STARSHIPS, $index));

        return $this->genericRequest($response);
    }

    public function getFilmsCollection(int $page=1)
    {
        $response = $this->httpClient->get(sprintf(self::COLLECTION, SwApiEnum::FILMS, $page));

        return $this->genericRequest($response);
    }

    public function getFilms(int $index)
    {
        $response = $this->httpClient->get(sprintf(self::SINGLE_RECORD, SwApiEnum::FILMS, $index));

        return $this->genericRequest($response);
    }


    public function getPeopleCollection(int $page=1)
    {
        $response = $this->httpClient->get(sprintf(self::COLLECTION, SwApiEnum::PEOPLE, $page));

        return $this->genericRequest($response);
    }

    public function getPeople(int $index)
    {
        $response = $this->httpClient->get(sprintf(self::SINGLE_RECORD, SwApiEnum::PEOPLE, $index));

        return $this->genericRequest($response);
    }

    public function getPlanetsCollection(int $page=1)
    {
        $response = $this->httpClient->get(sprintf(self::COLLECTION, SwApiEnum::PLANETS, $page));

        return $this->genericRequest($response);
    }

    public function getPlanets(int $index)
    {
        $response = $this->httpClient->get(sprintf(self::SINGLE_RECORD, SwApiEnum::PLANETS, $index));

        return $this->genericRequest($response);
    }

    public function getSpeciesCollection(int $page=1)
    {
        $response = $this->httpClient->get(sprintf(self::COLLECTION, SwApiEnum::SPECIES, $page));

        return $this->genericRequest($response);
    }

    public function getSpecies(int $index)
    {
        $response = $this->httpClient->get(sprintf(self::SINGLE_RECORD, SwApiEnum::SPECIES, $index));

        return $this->genericRequest($response);
    }

    public function getVehiclesCollection(int $page=1)
    {
        $response = $this->httpClient->get(sprintf(self::COLLECTION, SwApiEnum::VEHICLES, $page));

        return $this->genericRequest($response);
    }

    public function getVehicles(int $index)
    {
        $response = $this->httpClient->get(sprintf(self::SINGLE_RECORD, SwApiEnum::VEHICLES, $index));

        return $this->genericRequest($response);
    }

    public function getNextPage(string $route): StarWarsResponse
    {
        $method = sprintf('get%sCollection', ucfirst(explode('/', $route)[4]));

        $page = explode('=', explode('/', $route)[5])[1];

        return $this->$method($page);
    }

    public function getRecord(string $route) : StarWarsResponse
    {
        $route = rtrim($route, '/');

        $method = sprintf('get%s', ucfirst(explode('/', $route)[4]));

        $index = explode('/', $route)[5];

        return $this->$method($index);
    }
}