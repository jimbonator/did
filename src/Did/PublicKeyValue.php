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