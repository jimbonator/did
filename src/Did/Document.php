<?php

namespace Did;

/**
 *
 */
class Document extends Serializable implements \ArrayAccess {
  const DEFAULT_CONTEXT = 'https://w3id.org/did/v1';

  private $map = [];

  /**
   *
   */
  public function __construct(Uri $subject, string $context = self::DEFAULT_CONTEXT) {
    $this->set('@context', $context);
    $this->set('id', $subject);
  }

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
   *
   */
  public function set(string $key, $val) {
    Args::requires(is_string($val) || is_a($val, Serializable::class));

    $this->map[$key] = $val;
  }

  /**
   *
   */
  public function clear(string $key) {
    unset($this->map[$key]);
  }

  /**
   * @return string
   */
  public function context() {
    return $this->get('@context');
  }

  /**
   * @return \Did\Uri
   */
  public function subject() {
    return $this->get('id');
  }

  /**
   * @return \Did\Timestamp|null
   */
  public function created() {
    return $this->get('created');
  }

  /**
   *
   */
  public function setCreated(Timestamp $ts = null) {
    $this->set('created', $ts ?? new Timestamp());
  }

  /**
   * @return \Did\Timestamp|null
   */
  public function updated() {
    return $this->get('updated');
  }

  /**
   *
   */
  public function setUpdated(Timestamp $ts = null) {
    $this->set('updated', $ts ?? new Timestamp());
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
    $this->clear($offset);
  }

  //
  // Encodable
  //

  /**
   * @inheritDoc
   */
  public function toSerialize() {
    return $this->map;
  }
}
