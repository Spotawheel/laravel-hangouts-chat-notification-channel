<?php

namespace NotificationChannels\Discord;

use Exception;
use Illuminate\Support\Arr;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use NotificationChannels\Discord\Exceptions\CouldNotSendNotification;

class Discord
{
    protected $baseUrl = 'https://chat.googleapis.com/v1';

    protected $httpClient;

    protected $token;

    public function __construct(HttpClient $http, $token)
    {
        $this->httpClient = $http;
        $this->token = $token;
    }

    public function send($channel, array $data)
    {
        return $this->request('POST', 'channels/' . $channel . '/messages', $data);
    }

    protected function request($verb, $endpoint, array $data)
    {
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');

        try {
            $response = $this->httpClient->request($verb, $url, [
                'headers' => [
                    'Authorization' => 'Bot ' . $this->token,
                ],
                'json' => $data,
            ]);
        } catch (RequestException $exception) {
            if ($response = $exception->getResponse()) {
                throw CouldNotSendNotification::serviceRespondedWithAnHttpError($response);
            }

            throw CouldNotSendNotification::serviceCommunicationError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceCommunicationError($exception);
        }

        $body = json_decode($response->getBody(), true);

        if (Arr::get($body, 'code', 0) > 0) {
            throw CouldNotSendNotification::serviceRespondedWithAnApiError($body);
        }

        return $body;
    }
}