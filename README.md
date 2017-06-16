## Facebook Messenger send API
You started to write your but there is a problem - how to send back messages? 
You heads to the [Messenger platform send API](https://developers.facebook.com/docs/messenger-platform/send-api-reference)
and start to read the documentation.

As you progress with the reading, you'll understand that if you want to send a
text or an image required from to create and array with some confusing 
structure. But, that is not your worst problem - if you want to send generic 
template you need to send an enormous and confusing array.

This is where this library come in hand. The `Facebook Messenger send API` 
contains an object for each type of section in the send api for the Messenger
platform. Combine that with the autocomplete feature that exists in any modern
IDE and you'll get an easy way to construct the array.

Sending will be easy as well since there is a dedicated API for that. Let's dive
in!

## What are the principles and how they can assist you

If you'll have a look in the send api documentation you can see a specific 
structure:
* Content types
  * Text
  * Audio
  * Image
  * ...
* Templates
  * Button
  * Generic
  * List
  * ...
* Buttons
* Quick replies
* Sender
* ..

And inside, there are more fields and object. Let's have a look on how to start
the object:
```php
<?php

$facebook = new FacebookMessengerSendApi\SendAPI();

// The app access token.
$access_token = '';

// The user recipient ID.
$recipient = 0;

$facebook
  ->setAccessToken($access_token)
  ->setRecipientId($recipient);
```

After that, we need to start and build our payload object for a text(and sending
it as well):

```php
<?php

$message = $facebook->contentType->text->text('This is a message.');

$facebook->sendMessage($message);
```

What we can see here? Since the text in under the content type section, and the 
text section have only text the code is very easy to understand:
`$facebook->contentType->text->text('This is a message.')`

What about an image? Very easy:

`$facebook->contentType->audio->url(URL);`

### Templates and button
Button have their own section, and templates have their own section. How this 
will work:
```php
<?php

$message = $facebook->templates->generic
  ->addElement(
    $facebook->templates->element
      ->title('This is a title')
      ->addButton(
        $facebook->buttons->postBack
          ->title('This is a button')
          ->payload('button')
      )
      ->addButton(
        $facebook->buttons->postBack
          ->title('This is another button')
          ->payload('button2')
      )
  );

```

## Sending an action

Action are a bit different that that. Since it's not a crazy payload we have a 
very simple task for that:
```php
<?php
$message = $facebook->senderActions('TYPING_ON');
sleep(3);
$message = $facebook->senderActions('TYPING_OFF');
```
This will give the affect off typing bubbles and after 3 seconds they will 
disappear. Try it, it's cool :)

## Adding tag
You can add a [tag](https://developers.facebook.com/docs/messenger-platform/send-api-reference/tags) 
to your message:

```php
<?php

$message = $facebook->contentType->text->text('message');

$facebook
  ->setTag('A_TAG')
  ->sendMessage($message);

```

## Test it your self
After you'll get an access token and you find out the recipient user ID you can
try your code by writing in the `testing.php` and run it. 

If you don't know what is the user recipient ID(of your self in this case) you 
can get that by setting up the bot and start a conversation. Your recipient ID
will be in the payload of the request.

Don't forget to populate variables!

## Contribution
Documentation and unit testing will be more than welcome.
