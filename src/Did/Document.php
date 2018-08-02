<?php

namespace Did;

use Did\Util\Args;

/**
 *
 */
class Document extends AbstractMap {
  const DEFAULT_CONTEXT = 'https://w3id.org/did/v1';

  /**
   *
   */
  public function __construct(Uri $subject, string $context = self::DEFAULT_CONTEXT) {
    $this->set('@context', $context);
    $this->set('id', $subject);
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

  /**
   * @return array[\Did\PublicKey]
   */
  public function publicKey() {
    return $this->get('publicKey');
  }

  /**
   * @param \Did\PublicKey|array[\Did\PublicKey]|null
   */
  public function setPublicKey($pks) {
    Args::requires(is_a($pks, PublicKey::class) || is_array($pks) || is_null($pks));

    $this->set('publicKey', $pks);
  }
}
