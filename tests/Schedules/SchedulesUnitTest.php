<?php

namespace Otis22\VetmanagerConversations\Schedules;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;

use function Otis22\VetmanagerToken\token;
use function Otis22\VetmanagerToken\credentials;

class SchedulesUnitTest extends TestCase
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSchedules(): void
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    [],
                    '{
                        "success":true,
                        "message":"Records Retrieved Successfully",
                        "data":{
                            "totalCount":"1",
                            "timesheet":[
                                {
                                    "id":"2",
                                    "doctor_id":"1",
                                    "shedule_id":"0",
                                    "begin_datetime":"2021-01-05 08:00:00",
                                    "end_datetime":"2021-01-05 22:00:00",
                                    "type":"2",
                                    "shift":"0000-00-00 00:00:00",
                                    "title":"",
                                    "all_day":"0",
                                    "night":"1",
                                    "action_id":"0",
                                    "clinic_id":"1"
                                }
                            ],
                            "is_empty_shedules":1
                        }
                    }
                    '
                )
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $token = token(
            credentials(
                strval(getenv("VETMANAGER_USER")),
                strval(getenv("VETMANAGER_PASSWORD")),
                'app'
            ),
            strval(getenv("VETMANAGER_DOMAIN"))
        );

        $schedules = new Schedules($token, $client);
        $result = $schedules->byIntervalInDays(2);
        $this->assertTrue($result['success']);
    }
}
