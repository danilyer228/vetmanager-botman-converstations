<?php

namespace Otis22\VetmanagerConversations\Helpers;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;

use function Otis22\VetmanagerToken\token;
use function Otis22\VetmanagerToken\credentials;

class UsersUnitTest extends TestCase
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetAllUsers(): void
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
                          "totalCount":"2",
                          "user":[
                             {
                                "id":"1",
                                "last_name":"Admin",
                                "first_name":"\u0412\u043b\u0430\u0434\u0438\u043c\u0438\u0440",
                                "middle_name":"",
                                "login":"admin",
                                "passwd":"9205814c8bc98857f5e07f3bae30ad68",
                                "position_id":"8",
                                "email":"peixfntkilpdablk323am@awdrt.org",
                                "phone":"",
                                "cell_phone":"",
                                "address":"",
                                "role_id":"7",
                                "is_active":"1",
                                "calc_percents":"1",
                                "nickname":"admin",
                                "last_change_pwd_date":"0000-00-00",
                                "is_limited":"0",
                                "carrotquest_id":"devtr6:1",
                                "sip_number":"",
                                "user_inn":"",
                                "position":{
                                   "id":"8",
                                   "title":"\u0430\u0434\u043c\u0438\u043d\u0438\u0441\u0442\u0440\u0430\u0442",
                                   "admission_length":"00:30:00"
                                },
                                "role":{
                                   "id":"7",
                                   "name":"\u0410\u0434\u043c\u0438\u043d\u044b",
                                   "super":"1"
                                }
                             },
                             {
                                "id":"2",
                                "last_name":"\u0420\u043e\u043c\u0430\u043d\u0438\u0447\u0435\u0432",
                                "first_name":"Admin",
                                "middle_name":"",
                                "login":"admin1",
                                "passwd":"9205814c8bc98857f5e07f3bae30ad68",
                                "position_id":"8",
                                "email":"eepeixfntkilpdablkam@awdrt.org",
                                "phone":"",
                                "cell_phone":"",
                                "address":"",
                                "role_id":"7",
                                "is_active":"1",
                                "calc_percents":"1",
                                "nickname":"admin",
                                "last_change_pwd_date":"0000-00-00",
                                "is_limited":"0",
                                "carrotquest_id":"devtr6:1",
                                "sip_number":"",
                                "user_inn":"",
                                "position":{
                                   "id":"8",
                                   "title":"\u0430\u0434\u043c\u0438\u043d\u0438\u0441\u0442\u0440\u0430",
                                   "admission_length":"00:30:00"
                                },
                                "role":{
                                   "id":"7",
                                   "name":"\u0410\u0434\u043c\u0438\u043d\u044b",
                                   "super":"1"
                                }
                             }
                          ]
                       }
                    }
                    '
                )
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $token = token(
            credentials(
                strval(getenv("VETMANAGER_USER")),
                strval(getenv("VETMANAGER_PASSWORD")),
                'app'
            ),
            strval(getenv("VETMANAGER_DOMAIN"))
        );
        $client = new Client(['handler' => $handlerStack]);
        $users = new Users($token, $client);
        $result = $users->all();
        $this->assertTrue($result['success']);
    }

    public function testGetUser(): void
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
                          "user":[
                             {
                                "id":"1",
                                "last_name":"Admin",
                                "first_name":"\u0412\u043b\u0430\u0434\u0438\u043c\u0438\u0440",
                                "middle_name":"",
                                "login":"admin",
                                "passwd":"9205814c8bc98857f5e07f3bae30ad68",
                                "position_id":"8",
                                "email":"peixfntkilpdablk323am@awdrt.org",
                                "phone":"",
                                "cell_phone":"",
                                "address":"",
                                "role_id":"7",
                                "is_active":"1",
                                "calc_percents":"1",
                                "nickname":"admin",
                                "last_change_pwd_date":"0000-00-00",
                                "is_limited":"0",
                                "carrotquest_id":"devtr6:1",
                                "sip_number":"",
                                "user_inn":"",
                                "position":{
                                   "id":"8",
                                   "title":"\u0430\u0434\u043c\u0438\u043d\u0438\u0441\u0442\u0440\u0430\u0442",
                                   "admission_length":"00:30:00"
                                },
                                "role":{
                                   "id":"7",
                                   "name":"\u0410\u0434\u043c\u0438\u043d\u044b",
                                   "super":"1"
                                }
                             }
                          ]
                       }
                    }
                    '
                )
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $token = token(
            credentials(
                strval(getenv("VETMANAGER_USER")),
                strval(getenv("VETMANAGER_PASSWORD")),
                'app'
            ),
            strval(getenv("VETMANAGER_DOMAIN"))
        );
        $client = new Client(['handler' => $handlerStack]);
        $users = new Users($token, $client);
        $result = $users->byId(1);
        $this->assertTrue($result['success']);
    }
}
