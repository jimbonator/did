<?php

namespace Did;

use Did\Util\Args;

/**
 *
 */
class Authentication extends AbstractMap {
  /**
   * @param string|null $type
   * @param \Did\PublicKey|\Did\Uri|null $pk
   */
  public function __construct(string $type = null, $pk = null) {
    Args::optNonempty($type);
    Args::requires(is_a($pk, PublicKey::class) || is_a($pk, Uri::class) || is_null($pk));

    $this->set('type', $type);
    $this->set('publicKey', $pk);
  }

  /**
   * @return string
   */
  public function type() {
    return $this->get('type');
  }

  /**
   * @return \Did\PublicKey|\Did\Uri
   */
  public function publicKey() {
    return $this->get('publicKey');
  }

  /**
   * @return bool
   */
  public function isEmbedded() {
    return is_a($this->publicKey(), PublicKey::class);
  }

  /**
   * @return bool
   */
  public function isReference() {
    return is_a($this->publicKey(), Uri::class);
  }
}
