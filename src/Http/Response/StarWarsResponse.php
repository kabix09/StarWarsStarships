<?php

declare(strict_types=1);

namespace App\Http\Response;

use Psr\Http\Message\ResponseInterface;

class StarWarsResponse
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var array
     */
    private $decodedBody;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->decodedBody = json_decode((string) $response->getBody(), true);
    }

    public function getPsrResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function getResponseContent(): array
    {
        return $this->decodedBody;
    }
}