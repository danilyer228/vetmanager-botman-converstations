<?php

namespace Otis22\VetmanagerConversations\Schedules;

use GuzzleHttp\Client;
use Otis22\VetmanagerToken\Token;

use function Otis22\VetmanagerRestApi\uri;

class Schedules
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
     * @param int $days
     * @param int $doctor_id
     * @param int $clinic_id
     * @return array{success:bool}
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function byIntervalInDays($days = 7, $doctor_id = 0, $clinic_id = 0): array
    {
        $now = date("Y-m-d");
        $filter_query[] = [
            "property" => "end_datetime",
            "value" => date('Y-m-d', intval(strtotime($now . " +" . $days . " days"))) . " 23:59:59",
            "operator" => "<=",
        ];
        if ($doctor_id) {
            $filter_query[] = [
                "property" => 'doctor_id',
                "value" => $doctor_id,
                "operator" => "=",
            ];
        }
        if ($clinic_id) {
            $filter_query[] = [
                "property" => 'clinic_id',
                "value" => $clinic_id,
                "operator" => "=",
            ];
        }
        $request = $this->httpClient->request(
            'GET',
            uri("timesheet")->asString(),
            [
                "query" => [
                    "filter" => json_encode($filter_query)
                ]
            ]
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
