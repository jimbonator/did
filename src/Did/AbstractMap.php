<?php

namespace Did;

use Did\Util\Args;

/**
 *
 */
abstract class AbstractMap extends Serializable implements \ArrayAccess {
  private $map = [];

  /**
   * @return bool
   */
  public function has(string $key) {
    return isset($this->map[$key]);
  }

  /**
   * @return \Did\Serializable|string|null
   */
  public function get(string $key) {
    return isset($this->map[$key]) ? $this->map[$key] : null;
  }

  /**
   * @param string $key
   * @param string|\Did\Serializable|null $val
   */
  public function set(string $key, $val) {
    Args::requires(is_string($val) || is_a($val, Serializable::class) || is_null($val));

    if (isset($val))
      $this->map[$key] = $val;
    else
      $this->remove($key);
  }

  /**
   *
   */
  public function remove(string $key) {
    unset($this->map[$key]);
  }

  //
  // ArrayAccess
  //

  /**
   * @inheritDoc
   */
  public function offsetExists($offset) {
    return $this->has($offset);
  }

  /**
   * @inheritDoc
   */
  public function offsetGet($offset) {
    return $this->get($offset);
  }

  /**
   * @inheritDoc
   */
  public function offsetSet($offset, $value) {
    return $this->set($offset, $value);
  }

  /**
   * @inheritDoc
   */
  public function offsetUnset($offset) {
    $this->remove($offset);
  }

  //
  // Serializable
  //

  /**
   * @inheritDoc
   */
  protected function toSerialize() {
    return $this->map;
  }
}
