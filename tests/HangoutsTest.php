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

class HangoutsTest extends BaseTest
{
    /** @test */
    public function it_can_send_a_message()
    {
        //
    }
}