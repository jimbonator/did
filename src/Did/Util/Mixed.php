<?php

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
    static::req('\Did\Util\Mixed::isNonempty', $mixed);
  }

  /**
   *
   */
  public static function requires($bool) {
    if (!$bool)
      static::throw();
  }

  /**
   *
   */
  protected static function req($test, $mixed) {
    if (!$test($mixed))
      static::throw();
  }

  /**
   *
   */
  protected static function throw() {
    throw new \UnexpectedValueException();
  }
}