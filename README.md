# Hangouts notification channel for Laravel 5.6+, 6.0+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/hangouts.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/hangouts)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/hangouts/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/hangouts)
[![StyleCI](https://styleci.io/repos/65772492/shield)](https://styleci.io/repos/65772492)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/hangouts.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/hangouts)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/hangouts/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/hangouts/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/hangouts.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/hangouts)

This package makes it easy to send notifications using the [Hangouts Chat API](https://developers.google.com/hangouts/chat/) with Laravel.

## Contents

- [Hangouts notification channel for Laravel 5.6+](#hangouts-notification-channel-for-laravel-56)
    - [Contents](#contents)
    - [Installation](#installation)
    - [Usage](#usage)
        - [Available Message methods](#available-message-methods)
    - [Changelog](#changelog)
    - [Testing](#testing)
    - [Security](#security)
    - [Contributing](#contributing)
    - [Credits](#credits)
    - [License](#license)


## Installation

You can install the package via composer:

```bash
composer require laravel-notification-channels/hangouts
```

Next, you must load the service provider:

```php
// config/app.php
'providers' => [
    // ...
    NotificationChannels\Hangouts\HangoutsServiceProvider::class,
],
```

## Usage

In every model you wish to be notifiable via Hangouts, you must add a channel ID property to that model accessible through a `routeNotificationForHangouts` method:

```php
class Guild extends Eloquent
{
    use Notifiable;

    public function routeNotificationForHangouts()
    {
        return $this->hangouts_channel;
    }
}
```

> **NOTE**: Hangouts handles direct messages as though they are a regular channel. If you wish to allow users to receive direct messages from your bot, you will need to create a private channel with that user.
>
> An example workflow may look like the following:
>
> 1. Your `users` table has two hangouts columns: `hangouts_user_id` and `hangouts_private_channel_id`
> 2. When a user updates their Hangouts user ID (`hangouts_user_id`), generate and save a private channel ID (`hangouts_private_channel_id`)
> 3. Return the user's `hangouts_private_channel_id` in the `routeNotificationForHangouts` method on the `User` model
>
> You can generate direct message channels by using the `getPrivateChannel` method in the `NotificationChannels\Hangouts\Hangouts` class
>
> ```php
> use NotificationChannels\Hangouts\Hangouts;
>
> class UserHangoutsSettingsController
> {
>     public function store(Request $request)
>     {
>         $userId = $request->input('hangouts_user_id');
>         $channelId = app(Hangouts::class)->getPrivateChannel($userId);
>
>         Auth::user()->update([
>             'hangouts_user_id' => $userId,
>             'hangouts_private_channel_id' => $channelId,
>         ]);
>     }
> }
> ```
>
> Please take note that the `getPrivateChannel` method only accepts [Hangouts's snowflake IDs](https://hangoutsapp.com/developers/docs/reference#snowflakes). There is no API route provided by Hangouts to lookup a user's ID by their name and tag, and the process for copying and pasting a user ID can be confusing to some users. Because of this, it is recommended to add the option for users to connect their Hangouts account to their account within your application either by logging in with Hangouts or linking it to their pre-existing account.

You may now tell Laravel to send notifications to Hangouts channels in the `via` method:

```php
// ...
use NotificationChannels\Hangouts\HangoutsChannel;
use NotificationChannels\Hangouts\HangoutsMessage;

class GameChallengeNotification extends Notification
{
    public $challenger;

    public $game;

    public function __construct(Guild $challenger, Game $game)
    {
        $this->challenger = $challenger;
        $this->game = $game;
    }

    public function via($notifiable)
    {
        return [HangoutsChannel::class];
    }

    public function toHangouts($notifiable)
    {
        return HangoutsMessage::create("You have been challenged to a game of *{$this->game->name}* by **{$this->challenger->name}**!");
    }
}
```

### Available Message methods

* `body(string)`: Set the content of the message. ([Supports basic markdown](https://support.hangoutsapp.com/hc/en-us/articles/210298617-Markdown-Text-101-Chat-Formatting-Bold-Italic-Underline-))
* `embed(array)`: Set the embedded content. ([View embed structure](https://hangoutsapp.com/developers/docs/resources/channel#embed-object))

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
$ composer test
```

## Security

If you discover any security related issues, please email cs475x@icloud.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Cody Scott](https://github.com/codyphobe)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
