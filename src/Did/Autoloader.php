<?php

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
