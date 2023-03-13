<?php

namespace App\Twig\Runtime;

use App\Service\HttpClient;
use Twig\Extension\RuntimeExtensionInterface;

class HandleApiRelationRuntime implements RuntimeExtensionInterface
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchApiRelation($value)
    {
        return $this->httpClient->getRecord($value)->getResponseContent();
    }
}
