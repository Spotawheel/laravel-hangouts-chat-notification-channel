<?php

namespace NotificationChannels\Hangouts;

use Google_Client;
use Google_Service_HangoutsChat;
use Google_Service_HangoutsChat_Message;

class Hangouts
{
    protected $chat;

    public function __construct()
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope('https://www.googleapis.com/auth/chat.bot');
        $client->authorize();

        $this->chat = new Google_Service_HangoutsChat($client);
    }

    public function spaces()
    {
        return $this->chat->spaces->listSpaces();
    }

    public function send(string $space, HangoutsMessage $message)
    {
        $payload = new Google_Service_HangoutsChat_Message();
        $payload->setText($message->text);
        return $this->chat->spaces_messages->create($space, $payload);
    }
}
