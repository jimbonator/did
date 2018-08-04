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

namespace Did\Util;

/**
 *
 */
class Mixed {
  /**
   *
   */
  public static function isEmpty($mixed) {
    $type = gettype($mixed);
    switch ($type) {
      case 'NULL':
        return true;

      case 'array':
        return empty($mixed);

      case 'string':
        return $mixed === '';
    }
  }

  /**
   *
   */
  public static function isNonempty($mixed) {
    return !static::isEmpty($mixed);
  }

  /**
   *
   */
  public static function reqNonempty($mixed) {
    return static::req('\Did\Util\Mixed::isNonempty', $mixed);
  }

  /**
   *
   */
  public static function reqString($mixed) {
    return static::req('is_string', $mixed);
  }

  /**
   *
   */
  public static function requires($bool) {
    if (!$bool)
      static::throw();

    return $bool;
  }

  /**
   *
   */
  public static function optNonempty($mixed) {
    return static::opt('\Did\Util\Mixed::isNonempty', $mixed);
  }

  /**
   *
   */
  public static function optString($mixed) {
    return static::opt('is_string', $mixed);
  }

  /**
   *
   */
  protected static function req($test, $mixed) {
    if (!$test($mixed))
      static::throw();

    return $mixed;
  }

  /**
   *
   */
  protected static function opt($test, $mixed) {
    if (!is_null($mixed) && !$test($mixed))
      static::throw();

    return $mixed;
  }

  /**
   *
   */
  protected static function throw() {
    throw new \UnexpectedValueException();
  }
}