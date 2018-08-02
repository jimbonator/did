<?php

namespace Did;

use Did\Util\Json;

/**
 *
 */
abstract class Serializable implements \JsonSerializable {
  /**
   * @inheritDoc
   */
  public function jsonSerialize() {
    return $this->toSerialize();
  }

  /**
   * @return string
   */
  public function encode() {
    $to_serialize = $this->toSerialize();

    return is_string($to_serialize) ? $to_serialize : Json::encode($to_serialize);
  }

  /**
   * @return string
   */
  public function __toString() {
    return $this->encode();
  }

  /**
   * @return mixed
   */
  protected abstract function toSerialize();
}
