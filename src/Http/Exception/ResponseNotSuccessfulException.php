<?php

declare(strict_types=1);

namespace App\Http\Exception;

use Psr\Http\Message\ResponseInterface;

class ResponseNotSuccessfulException extends \Exception
{
    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(ResponseInterface $response, int $expectedResponseCode = 200)
    {
        parent::__construct("Response not successful. Expected response code $expectedResponseCode, got {$response->getStatusCode()}.");

        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}