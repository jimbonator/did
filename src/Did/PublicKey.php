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
