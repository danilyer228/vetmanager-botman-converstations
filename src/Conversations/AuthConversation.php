<?php

declare(strict_types=1);

namespace Otis22\VetmanagerConversations\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

use function Otis22\VetmanagerUrl\url;
use function Otis22\VetmanagerToken\token;
use function Otis22\VetmanagerToken\credentials;

final class AuthConversation extends Conversation
{
    /**
     * @var string
     */
    private $appName;

    /**
     * @var string
     */
    protected $clinicUrl;
    /**
     * @var string
     */
    protected $userLogin;
    /*
     * @var string
     */
    protected $token;

    /**
     * AuthConversation constructor.
     * @param string $appName
     */
    public function __construct(string $appName)
    {
        $this->appName = $appName;
    }

    /**
     * @return Conversation
     */
    public function askDomain(): Conversation
    {
        return $this->ask(
            "Введите доменное имя или адрес программы. Пример: myclinic или https://myclinic.vetmanager.ru",
            function (Answer $answer) {
                try {
                    $this->clinicUrl = url($answer->getValue())->asString();
                    $this->askLogin();
                } catch (\Throwable $exception) {
                    $this->say("Попробуйте еще раз. Ошибка: " . $exception->getMessage());
                    $this->askDomain();
                }
            }
        );
    }

    /**
     * @return Conversation
     */
    public function askLogin(): Conversation
    {
        return $this->ask("Введите login вашего пользователя в Ветменеджер", function (Answer $answer) {
            $this->userLogin = $answer->getValue();
            $this->askPassword();
        });
    }

    public function askPassword(): Conversation
    {
        return $this->ask("Введите пароль вашего пользователя в Ветменеджер", function (Answer $answer) {
            $password = $answer->getValue();
            $credentials = credentials(
                $this->userLogin,
                $password,
                $this->appName
            );
            try {
                $token = token($credentials, $this->clinicUrl)->asString();
                $this->getBot()->userStorage()
                    ->save(
                        ['clinicUserToken' => $token]
                    );
                $this->say('Токен получен. Теперь бот может выполнять ваши команды.');
            } catch (\Throwable $exception) {
                $this->say("Попробуйте еще раз. Ошибка: " . $exception->getMessage());
                $this->askDomain();
            }
        });
    }

    public function run()
    {
        $this->askDomain();
    }
}
