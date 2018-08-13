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

use Did\Exception\EncodingException;
use Did\Util\Args;
use Did\Util\Str;

/**
 *
 */
class Uri extends Serializable {
  /**
   * DID scheme.
   *
   * @var string
   */
  const SCHEME = 'did';

  /**
   * Path delimiter.
   *
   * @var string
   */
  const DELIM_PATH = '/';

  /**
   * Fragment delimiter.
   *
   * @var string
   */
  const DELIM_FRAGMENT = '#';

  /**
   * Regular expression for decoding DID.
   *
   * @var string
   */
  const REGEX = '~^did:([a-z]+):([A-Za-z0-9:.-]+)(?<!:)(/[A-Za-z0-9-._\~%!$&\'()*+,;=:@/]*)?(#[A-Za-z0-9-._\~%!$&\'()*+,;=:@/?]*)?$~';

  private $method;
  private $ids;
  private $path;
  private $fragment;

  /**
   * @param string $method
   * @param string|array $ids
   * @param string|null $path
   * @param string|null $fragment
   */
  public function __construct(string $method, $ids, string $path = null, $fragment = null) {
    Args::reqNonempty($method);
    Args::reqNonempty($ids);
    Args::requires(is_string($ids) || is_array($ids));

    $this->method = $method;
    $this->ids = (array) $ids;
    $this->path = static::normalizePath($path);
    $this->fragment = static::normalizeFragment($fragment);
  }

  /**
   * @param string $uri`
   * @return bool
   */
  public static function isDid(string $uri) {
    return preg_match(static::REGEX, $uri) != 0;
  }

  /**
   * @param string $uri
   * @return \Did\Uri
   * @throws \Did\Exception\EncodingException
   */
  public static function parse(string $uri) {
    $matches = [];
    if (preg_match(static::REGEX, $uri, $matches) == 0)
      throw new EncodingException("Not a valid DID URI: \"$uri\"");

    // $matches[2] is one or more colon-delimited ids, break into array for ctor
    return new static($matches[1], explode(':', $matches[2]), $matches[3], $matches[4]);
  }

  /**
   * @return string
   */
  public function method() {
    return $this->method;
  }

  /**
   * @return array
   */
  public function ids() {
    return $this->ids;
  }

  /**
   * @return string
   */
  public function primaryId() {
    return $this->ids[0];
  }

  /**
   * @return bool
   */
  public function hasPath() {
    return isset($this->path);
  }

  /**
   * @return string|null
   */
  public function path() {
    return $this->path;
  }

  /**
   * @return bool
   */
  public function hasFragment() {
    return isset($this->fragment);
  }

  /**
   * @return string|null
   */
  public function fragment() {
    return $this->fragment;
  }

  /**
   * @inheritDoc
   */
  protected function toSerialize() {
    return sprintf('%s:%s:%s%s%s',
      static::SCHEME,
      $this->method,
      implode(':', $this->ids),
      $this->hasPath() ? $this->path : '',
      $this->hasFragment() ? (static::DELIM_FRAGMENT . $this->fragment) : ''
    );
  }

  /**
   * @inheritDoc
   */
  public function __toString() {
    return $this->toSerialize();
  }

  /**
   * @param string|null $fragment
   * @return string|null
   */
  private static function normalizePath($path) {
    Args::optString($path);

    // empty string and '/' => NULL
    if (Args::isEmpty($path) || ($path === static::DELIM_PATH))
      return null;

    // ensure path starts with delimiter
    if (!Str::hasPrefix($path, static::DELIM_PATH))
      $path = static::DELIM_PATH . $path;

    // trim trailing delimiter
    if (Args::isNonempty($path))
      $path = rtrim($path, static::DELIM_PATH);

    return $path;
  }

  /**
   * @param string $fragment
   * @return string|null
   */
  private static function normalizeFragment($fragment) {
    Args::optString($fragment);

    // empty string and '#' => null
    if (Args::isEmpty($fragment) || ($fragment === static::DELIM_FRAGMENT))
      return null;

    // trim leading delimiter
    $fragment = ltrim($fragment, static::DELIM_FRAGMENT);

    return $fragment;
  }
}
