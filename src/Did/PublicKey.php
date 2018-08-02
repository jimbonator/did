<?php

namespace Did;

use Did\Util\Args;

/**
 *
 */
class PublicKey extends AbstractMap {
  private $value;

  /**
   *
   */
  public function __construct(Uri $did, string $type, PublicKeyValue $value) {
    Args::reqNonempty($type);

    $this->set('id', $did);
    $this->set('type', $type);
    $this->set($value->name(), $value);

    $this->value = $value;
  }

  /**
   * @return \Did\Uri
   */
  public function id() {
    return $this->get('id');
  }

  /**
   * @return string
   */
  public function type() {
    return $this->get('type');
  }

  /**
   * @return \Did\PublicKeyValue
   */
  public function value() {
    return $this->value;
  }

  /**
   * @param \Did\Uri|null $did
   */
  public function setOwner(Uri $did = null) {
    $this->set('owner', $did);
  }

  /**
   * @return \Did\Uri|null
   */
  public function owner() {
    return $this->get('owner');
  }
}
