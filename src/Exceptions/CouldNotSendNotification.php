<?php

namespace NotificationChannels\Hangouts\Exceptions;

class CouldNotSendNotification extends \Exception
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return static
     */
    public static function serviceRespondedWithAnHttpError(ResponseInterface $response)
    {
        $message = "Hangouts responded with an HTTP error: {$response->getStatusCode()}";
        if ($error = Arr::get(json_decode($response->getBody(), true), 'message')) {
            $message .= ": $error";
        }
        return new static($message);
    }

    /**
     * @param array $response
     *
     * @return static
     */
    public static function serviceRespondedWithAnApiError(array $response)
    {
        return new static("Hangouts responded with an API error: {$response['code']}: {$response['message']}");
    }

    /**
     * @param \Exception $exception
     *
     * @return static
     */
    public static function serviceCommunicationError(Exception $exception)
    {
        return new static("Communication with Hangouts failed: {$exception->getCode()}: {$exception->getMessage()}");
    }
}