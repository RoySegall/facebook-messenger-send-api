<?php

/**
 * Using this file for testing the code of this package.
 */

require_once __DIR__ . '/vendor/autoload.php';

$facebook = new FacebookMessengerSendApi\SendAPI();

// The app access token.
$access_token = '';

// The user recipient ID.
$recipient = 0;

$facebook
  ->setAccessToken($access_token)
  ->setRecipientId($recipient);

$message = $facebook->contentType->text->text('message');

$facebook
  ->sendMessage($message);

