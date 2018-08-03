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

use Did\Util\Json;

/**
 *
 */
abstract class Serializable implements \JsonSerializable {
  /**
   * @inheritDoc
   */
  public function jsonSerialize() {
    return $this->toSerialize();
  }

  /**
   * @return string
   */
  public function encode() {
    $to_serialize = $this->toSerialize();

    return is_string($to_serialize) ? $to_serialize : Json::encode($to_serialize);
  }

  /**
   * @return string
   */
  public function __toString() {
    return $this->encode();
  }

  /**
   * @return mixed
   */
  protected abstract function toSerialize();
}
