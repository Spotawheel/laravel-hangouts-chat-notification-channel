<?php

namespace NotificationChannels\Hangouts\Tests;

use Mockery;
use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as HttpClient;
use NotificationChannels\Hangouts\Hangouts;
use GuzzleHttp\Exception\RequestException;
use NotificationChannels\Hangouts\Exceptions\CouldNotSendNotification;


class HangoutsTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function spaces_messages_create()
    {
        $chat = new Hangouts();
        $spacesResult = $chat->spaces();

        foreach ($spacesResult->spaces as $space) {
            $sendResult = $chat->send($space->name, 'Hello world!');
            echo json_encode($sendResult);
        }
    }
}