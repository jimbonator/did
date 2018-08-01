<?php

namespace Did;

use Did\Exception\JsonEncodingException;

/**
 *
 */
class Json {
  /**
   * @return string
   * @throws \Did\Exception\JsonEncodingException
   */
  function encode($val, int $options = JSON_UNESCAPED_SLASHES) {
    $encoded = json_encode($val, $options);
    if ($encoded === false)
      throw new JsonEncodingException();

    return $encoded;
  }
}
