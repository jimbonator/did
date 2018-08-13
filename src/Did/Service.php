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
class Service extends AbstractMap {
  /**
   * @param \Did\Uri $id
   * @param string $type
   * @param string $endpoint
   */
  public function __construct(\Did\Uri $id, string $type, string $endpoint) {
    $this->set('id', $id);
    $this->set('type', $type);
    $this->set('serviceEndpoint', $endpoint);
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
   * @return string
   */
  public function endpoint() {
    return $this->get('serviceEndpoint');
  }
}
