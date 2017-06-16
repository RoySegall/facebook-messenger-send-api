<?php

namespace FacebookMessengerSendApi;

use FacebookMessengerSendApi\Buttons\FacebookButtons;
use FacebookMessengerSendApi\ContentType\FacebookContentType;
use FacebookMessengerSendApi\Templates\FacebookTemplates;
use GuzzleHttp\Client;

class SendAPI {

  /**
   * @var FacebookContentType
   */
  public $contentType;

  /**
   * @var FacebookButtons
   */
  public $buttons;

  /**
   * @var FacebookTemplates
   */
  public $templates;

  /**
   * @var QuickReplies
   */
  public $quickReplies;

  /**
   * @var QuickReply
   */
  public $quickReply;

  /**
   * @var AttachmentUploadAPI
   */
  public $attachmentUploadAPI;

  /**
   * The access token of the app.
   *
   * @var string
   */
  protected $accessToken;

  /**
   * The user ID.
   *
   * @var integer
   */
  protected $recipientId;

  /**
   * SendAPI constructor.
   */
  public function __construct() {
    $this->contentType = new FacebookContentType();
    $this->buttons = new FacebookButtons();
    $this->templates = new FacebookTemplates();
    $this->quickReplies = new QuickReplies();
    $this->quickReply = new QuickReply();
    $this->attachmentUploadAPI = new AttachmentUploadAPI();
  }

  /**
   * Get the access token.
   *
   * @return string
   *   The access token of the app.
   */
  public function getAccessToken() {
    return $this->accessToken;
  }

  /**
   * Set the access token.
   *
   * @param string $accessToken
   *   The access token of the app.
   *
   * @return SendAPI
   *   The current instance.
   */
  public function setAccessToken($accessToken) {
    $this->accessToken = $accessToken;

    return $this;
  }

  /**
   * Set the user ID which will receive the message.
   *
   * @param int $recipientId
   *   The user ID.
   *
   * @return SendAPI
   *   The current instance.
   */
  public function setRecipientId($recipientId) {
    $this->recipientId = $recipientId;

    return $this;
  }

  /**
   * Get the user ID.
   *
   * @return int
   *   The user ID.
   */
  public function getRecipientId() {
    return $this->recipientId;
  }

  /**
   * Sending a message.
   *
   * @param array|string $text
   *   The text is self or an array matching the send API.
   *
   * @return \Psr\Http\Message\ResponseInterface
   */
  public function sendMessage($text) {
    if ($text instanceof SendAPITransform) {
      $message = $text->getData();
    }
    else {
      $message = !is_array($text) ? $message = ['text' => $text] : $text;
    }

    return $this->send('message', $message);
  }

  /**
   * Send an action to the user.
   *
   * @param $action
   *   The action: mark_seen, typing_on or typing_off.
   *
   * @return \Psr\Http\Message\ResponseInterface
   */
  public function senderActions($action) {
    return $this->send('sender_action', $action);
  }

  /**
   * Sending to the facebook messenger some payload.
   *
   * It could be a message with attachment or or a sender action.
   *
   * @param $key
   *   If you want to send a message the key need to be 'message'. If not, use
   *   'sender_action'
   *
   * @param $value
   *   The value of the payload.
   *
   * @return \Psr\Http\Message\ResponseInterface
   */
  protected function send($key, $value) {
    $options = [
      'form_params' => [
        'recipient' => [
          'id' => $this->recipientId,
        ],
        $key => $value,
      ],
    ];

    if (!empty($this->tag)) {
      // Adding the tag to the body.
      $options['form_params']['tag'] = $this->tag;
    }

    return $this->guzzle()->post('https://graph.facebook.com/v2.6/me/messages?access_token=' . $this->accessToken, $options);
  }

  /**
   * Extracting information from the request.
   *
   * @param \stdClass $request
   *   The request object.
   *
   * @return array
   *   Array of the request.
   */
  protected function extractFacebookRequest(\stdClass $request) {
    $payload = $request->entry[0];
    $message = $payload->messaging[0];

    $payload = [
      'id' => $payload->id,
      'time' => $payload->time,
      'sender' => $message->sender->id,
      'recipient' => $message->recipient->id,
      'text' => $message->message->text,
      'mid' => $message->message->mid,
      'seq' => $message->message->seq,
    ];

    if (!empty($message->postback)) {
      // This is a post back button. Add it to the payload variable.
      $payload['postback'] = $message->postback->payload;
    }

    return $payload;
  }

  /**
   * Get the sender information.
   *
   * @param $id
   *   The ID of the user.
   * @param string $fields
   *   The fields we desire to retrieve. Default to first and last name. The
   *   fields separated by comma.
   *
   * @return mixed
   */
  protected function getSenderInfo($id, $fields = 'first_name,last_name') {
    return json_decode($this->guzzle()->get('https://graph.facebook.com/v2.6/' . $id, [
      'query' => [
        'access_token' => $this->accessToken,
        'fields' => $fields,
      ],
    ])->getBody());
  }

  /**
   * Alias for guzzle.
   *
   * @return \GuzzleHttp\Client
   *   Guzzle object.
   */
  public function guzzle() {
    return new Client();
  }

}
