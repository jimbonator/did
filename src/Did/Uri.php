<?php

namespace Did;

use Did\Exception\EncodingException;
use Did\Util\Args;

/**
 *
 */
class Uri extends Serializable {
  /**
   * DID prefix.
   *
   * @var string
   */
  const PREFIX = 'did';

  /**
   * Regular expression for decoding DID.
   *
   * @var string
   * @todo did-path, did-fragment, full idstring
   */
  const REGEX = '/^did:([a-z]+):([A-Za-z0-9.-]+)$/';

  private $method;
  private $ids;

  /**
   * @param string $method
   * @param string|array $ids
   */
  public function __construct(string $method, $ids) {
    Args::reqNonempty($method);
    Args::reqNonempty($ids);
    Args::requires(is_string($ids) || is_array($ids));

    $this->method = $method;
    $this->ids = (array) $ids;
  }

  /**
   * @param string $uri`
   * @return bool
   */
  public static function isDid(string $uri) {
    return preg_match(static::REGEX, $uri) != 0;
  }

  /**
   * @param string $uri
   * @return \Did\Uri
   * @throws \Did\Exception\EncodingException
   */
  public static function parse(string $uri) {
    $matches = [];
    if (preg_match(static::REGEX, $uri, $matches) == 0)
      throw new EncodingException("Not a valid DID URI: \"$uri\"");

    return new static($matches[1], $matches[2]);
  }

  /**
   * @return string
   */
  public function method() {
    return $this->method;
  }

  /**
   * @return array
   */
  public function ids() {
    return $this->ids;
  }

  /**
   * @return string
   */
  public function primaryId() {
    return $this->ids[0];
  }

  /**
   * @inheritDoc
   */
  public function toSerialize() {
    return sprintf('%s:%s:%s',
      static::PREFIX,
      $this->method,
      implode(':', $this->ids)
    );
  }

  /**
   * @inheritDoc
   */
  public function __toString() {
    return $this->toSerialize();
  }
}
