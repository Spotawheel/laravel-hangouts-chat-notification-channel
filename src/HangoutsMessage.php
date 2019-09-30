<?php

namespace NotificationChannels\Hangouts;

class HangoutsMessage
{
    public $text;
    public $space;

    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    public function space($space)
    {
        $this->space = $space;

        return $this;
    }
}