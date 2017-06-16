<?php

namespace FacebookMessengerSendApi;

interface SendAPITransformInterface {

  /**
   * @return array
   */
  public function getData();

  /**
   * Reset the element.
   *
   * @return $this
   */
  public function reset();

}
