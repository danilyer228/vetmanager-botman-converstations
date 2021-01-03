<?php

declare(strict_types=1);

namespace Otis22\VetmanagerConversations\Conversations;

use BotMan\BotMan\BotMan;
use Otis22\VetmanagerConversations\BotManTestCase;
use BotMan\BotMan\Drivers\Tests\FakeDriver;
use BotMan\BotMan\BotManFactory;
use BotMan\Studio\Testing\BotManTester;

class AuthConversationTest extends BotManTestCase
{
    public function testRun(): void
    {
        $this->botman->hears('message', function (BotMan $bot) {
            $bot->startConversation(new AuthConversation('test-app'));
        });

        $this->tester->receives('message')
            ->receives(
                strval(
                    getenv('VETMANAGER_DOMAIN')
                )
            )
            ->receives(
                strval(
                    getenv('VETMANAGER_USER')
                )
            )
            ->receives(
                strval(
                    getenv('VETMANAGER_PASSWORD')
                )
            )
            ->assertReply('Токен получен. Теперь бот может выполнять ваши команды.');
    }
}
