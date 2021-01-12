<?php

namespace Otis22\VetmanagerConversations\Helpers;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

use function Otis22\VetmanagerToken\token;
use function Otis22\VetmanagerToken\credentials;
use function Otis22\VetmanagerRestApi\byToken;
use function Otis22\VetmanagerUrl\url;

class UsersTest extends TestCase
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetAllUsers(): void
    {
        $token = token(
            credentials(
                strval(getenv("VETMANAGER_USER")),
                strval(getenv("VETMANAGER_PASSWORD")),
                'app'
            ),
            strval(getenv("VETMANAGER_DOMAIN"))
        );
        $client = new Client(
            [
                'base_uri' => url(strval(getenv("VETMANAGER_DOMAIN")))->asString(),
                'headers' => byToken('app', $token->asString())->asKeyValue()
            ]
        );
        $users = new Users($token, $client);
        $result = $users->all();
        $this->assertTrue($result['success']);
    }

    public function testGetUser(): void
    {
        $token = token(
            credentials(
                strval(getenv("VETMANAGER_USER")),
                strval(getenv("VETMANAGER_PASSWORD")),
                'app'
            ),
            strval(getenv("VETMANAGER_DOMAIN"))
        );
        $client = new Client(
            [
                'base_uri' => url(strval(getenv("VETMANAGER_DOMAIN")))->asString(),
                'headers' => byToken('app', $token->asString())->asKeyValue()
            ]
        );
        $users = new Users($token, $client);
        $result = $users->byId(1);
        $this->assertTrue($result['success']);
    }
}
