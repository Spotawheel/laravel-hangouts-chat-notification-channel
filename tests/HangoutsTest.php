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
    public function list_spaces()
    {
        $chat = new Hangouts();
        $data = $chat->spaces();
        var_dump($data->spaces);
    }
}