<?php

namespace NotificationChannels\Hangouts;

use Exception;
use Google_Client;
use Google_Service_HangoutsChat;
use Google_Service_HangoutsChat_Message;
use Google_Service_HangoutsChat_Space;
use Illuminate\Support\Arr;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use NotificationChannels\Hangouts\Exceptions\CouldNotSendNotification;

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

    public function send(string $spaceId, string $text)
    {
        $msg = new Google_Service_HangoutsChat_Message();
        $msg->setText($text);
        return $this->chat->spaces_messages->create('spaces/' . $spaceId, $msg);
    }
}