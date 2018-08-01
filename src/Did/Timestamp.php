<?php

namespace Did;

/**
 *
 */
class Timestamp extends Serializable {
  private $time_t;

  /**
   *
   */
  public function __construct(int $time_t = null) {
    $this->time_t = isset($time_t) ? $time_t : time();
  }

  /**
   *
   */
  public static function parse(string $ts) {
  }

  /**
   * @return int
   */
  public function time_t() {
    return $this->time_t;
  }

  /**
   * @inheritDoc
   */
  protected function toSerialize() {
    return date('Y-m-d\TH:i:s\Z', $this->time_t);
  }
}
