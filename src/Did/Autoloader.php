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
class Autoloader {
  /**
   *
   */
  public static function register() {
    return spl_autoload_register(function ($class) {
      static::autoload($class);
    });
  }

  /**
   *
   */
  private static function autoload($class) {
    if (strpos($class, 'Did\\') !== 0)
      return;

    $is_test = (strpos($class, 'Did\\Test\\') === 0);

    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $path = !$is_test ? "src/$path.php" : "test/$path.php";

    if (is_file($path))
      require_once($path);
  }
}
