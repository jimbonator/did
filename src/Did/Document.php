<?php

/**
 * Copyright (C) 2018 Internet Archive
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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
   * @return array[\Did\PublicKey]|null
   */
  public function publicKey() {
    return $this->get('publicKey');
  }

  /**
   * @param \Did\PublicKey|array[\Did\PublicKey]|null
   */
  public function setPublicKey($pks) {
    Args::requires(is_a($pks, PublicKey::class) || is_array($pks) || is_null($pks));

    $pks = !Args::isEmpty($pks) ? (array) $pks : null;

    $this->set('publicKey', $pks);
  }

  /**
   * @return array[\Did\Authentication]|null
   */
  public function authentication() {
    return $this->get('authentication');
  }

  /**
   * @param \Did\Authentication|array[\Did\Authentication]|null $authn
   */
  public function setAuthentication($authn) {
    Args::requires(is_a($authn, \Did\Authentication::class) || is_array($authn) || is_null($authn));

    $authn = !Args::isEmpty($authn) ? (array) $authn : null;

    $this->set('authentication', $authn);
  }

  /**
   * @return array[\Did\Service]|null
   */
  public function service() {
    return $this->get('service');
  }

  /**
   * @param \Did\Service|array[\Did\Service]|null $service
   */
  public function setService(array $service) {
    Args::requires(is_a($service, Service::class) || is_array($service) || is_null($service));

    $service = !Args::isEmpty($service) ? (array) $service : null;

    $this->set('service', $service);
  }
}
