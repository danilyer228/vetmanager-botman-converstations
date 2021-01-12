<?php

namespace Otis22\VetmanagerConversations\Helpers;

use GuzzleHttp\Client;
use Otis22\VetmanagerToken\Token;

use function Otis22\VetmanagerRestApi\uri;

class Users
{
    /**
     * @var Token
     */
    private $token;
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * Schedules constructor.
     * @param Token $token
     * @param Client $httpClient
     */
    public function __construct(Token $token, Client $httpClient)
    {
        $this->token = $token;
        $this->httpClient = $httpClient;
    }

    /**
     * @return array{success:bool}
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(): array
    {
        $request = $this->httpClient->request(
            'GET',
            uri("user")->asString()
        );
        $result = json_decode(
            strval(
                $request->getBody()
            ),
            true
        );
        return $result;
    }

    /**
     * @int $id
     * @return array{success:bool}
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function byId(int $id): array
    {
        $request = $this->httpClient->request(
            'GET',
            uri("user")->asString() . '/' . $id
        );
        $result = json_decode(
            strval(
                $request->getBody()
            ),
            true
        );
        return $result;
    }
}
