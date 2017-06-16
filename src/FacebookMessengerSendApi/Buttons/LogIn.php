<?php

namespace FacebookMessengerSendApi\Buttons;

use FacebookMessengerSendApi\SendAPITransform;

/**
 * Class LogIn.
 *
 * @see https://developers.facebook.com/docs/messenger-platform/account-linking/link-account
 */
class LogIn extends SendAPITransform implements ButtonInterface {

  /**
   * LogIn constructor.
   */
  public function __construct() {
    $this->data['type'] = 'account_link';
  }

  /**
   * Set the URl.
   *
   * @param $url
   *   The URl.
   *
   * @return $this
   */
  public function url($url) {
    $this->data['url'] = $url;

    return $this;
  }

}
