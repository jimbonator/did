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

/**
 *
 */
class Timestamp extends Serializable {
  private $time_t;

  /**
   *
   */
  public function __construct(int $time_t = null) {
    $this->time_t = isset($time_t) ? $time_t : time();
  }

  /**
   *
   */
  public static function parse(string $ts) {
  }

  /**
   * @return int
   */
  public function time_t() {
    return $this->time_t;
  }

  /**
   * @inheritDoc
   */
  protected function toSerialize() {
    return date('Y-m-d\TH:i:s\Z', $this->time_t);
  }
}
