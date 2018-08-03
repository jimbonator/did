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
