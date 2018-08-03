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

namespace Did\Test;

require_once 'vendor/autoload.php';
require_once 'src/Did/Autoloader.php';
\Did\Autoloader::register();

use Did\Uri;

/**
 *
 */
class UriTest extends TestCase {
  /**
   * @dataProvider provideIsNotDid
   */
  public function testIsNotDid($did) {
    $result = Uri::isDid($did);

    $this->assertFalse($result);
  }

  public function provideIsNotDid() {
    return [
      'empty' =>                  [ '' ],
      'prefix' =>                 [ 'did:' ],
      'prefix-method' =>          [ 'did:a' ],
      'prefix-number' =>          [ 'did:1' ],
      'bad-method' =>             [ 'did:123:deadbeef' ],
      'base-no-method' =>         [ 'did::deadbeef' ],
    ];
  }

  /**
   * @dataProvider provideIsDid
   */
  public function testIsDid($did) {
    $result = Uri::isDid($did);

    $this->assertTrue($result);
  }

  public function provideIsDid() {
    return [
      'base' =>                   [ 'did:method:deadbeef' ],
      'base-upper-id' =>          [ 'did:method:DEADBEEF' ],
      'base-mixed-id' =>          [ 'did:method:dEAdb33F' ],
    ];
  }

  /**
   * @dataProvider provideParse
   */
  public function testParse($did) {
    $uri = Uri::parse($did);
    $encoded = $uri->encode();

    $this->assertSame($did, $encoded);
  }

  public function provideParse() {
    return [
      'base' =>                   [ 'did:method:deadbeef' ],
      'base-mixed' =>             [ 'did:method:DeaDb33F' ],
    ];
  }
}
