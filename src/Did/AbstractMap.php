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
abstract class AbstractMap extends Serializable implements \ArrayAccess {
  private $map = [];

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
   * @param string $key
   * @param string|array|\Did\Serializable|null $val
   */
  public function set(string $key, $val) {
    Args::requires(is_string($val) || is_array($val) || is_a($val, Serializable::class) || is_null($val));

    if (isset($val))
      $this->map[$key] = $val;
    else
      $this->remove($key);
  }

  /**
   *
   */
  public function remove(string $key) {
    unset($this->map[$key]);
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
    $this->remove($offset);
  }

  //
  // Serializable
  //

  /**
   * @inheritDoc
   */
  protected function toSerialize() {
    return $this->map;
  }
}
