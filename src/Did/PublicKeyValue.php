<?php

namespace Did;

use Did\Util\Args;

/**
 *
 */
class PublicKeyValue extends Serializable {
  const PK_PEM =    'publicKeyPem';
  const PK_JWK =    'publicKeyJwk';
  const PK_HEX =    'publicKeyHex';
  const PK_BASE64 = 'publicKeyBase64';

  private $name;
  private $value;

  /**
   *
   */
  public function __construct(string $name, string $value) {
    Args::reqNonempty($name);
    Args::reqNonempty($value);

    $this->name = $name;
    $this->value = $value;
  }

  /**
   * @return string
   */
  public function name() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function value() {
    return $this->value;
  }

  /**
   * @inheritDoc
   */
  public function encode() {
    return "{$this->name}: {$this->value}";
  }

  /**
   * @inheritDoc
   */
  protected function toSerialize() {
    return $this->value;
  }
}