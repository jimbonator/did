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

  /**
   * @dataProvider provideIsNotDid
   * @expectedException \Did\Exception\EncodingException
   */
  public function testParseFailed($did) {
    Uri::parse($did);
  }

  public function provideIsNotDid() {
    return [
      'empty' =>                      [ '' ],
      'prefix' =>                     [ 'did:' ],
      'prefix-method' =>              [ 'did:a' ],
      'prefix-number' =>              [ 'did:1' ],
      'bad-method' =>                 [ 'did:123:deadbeef' ],
      'base-no-method' =>             [ 'did::deadbeef' ],
      'base-method-no-id-path' =>     [ 'did:method/path' ],
      'base-method-no-id-path2' =>    [ 'did:method:/path' ],
      'ids-trailing-colon' =>         [ 'did:method:deadbeef:abcd1234:' ],
      'ids-trailing-colon-path' =>    [ 'did:method:deadbeef:abcd1234:/abc/def' ],
      'path-no-opening-slash' =>      [ 'did:method:deadbeef%20%2F' ],
    ];
  }

  /**
   * @dataProvider provideIsDid
   */
  public function testIsDid($did) {
    $result = Uri::isDid($did);

    $this->assertTrue($result);
  }

  /**
   * @dataProvider provideIsDid
   */
  public function testParse($did, $normalized, $method, $ids, $path = null, $fragment = null) {
    $uri = Uri::parse($did);

    $this->assertSame($normalized ?? $did, $uri->encode());
    $this->assertSame($method, $uri->method());
    if (is_string($ids))
      $this->assertSame($ids, $uri->primaryId());
    else
      $this->assertSame($ids[0], $uri->primaryId());
    $this->assertSame((array) $ids, $uri->ids());
    $this->assertSame($path, $uri->path());
    $this->assertSame($fragment, $uri->fragment());
  }

  public function provideIsDid() {
    return [
      'base' =>
        [ 'did:method:deadbeef', null, 'method', 'deadbeef' ],

      'base-upper-id' =>
        [ 'did:method:DEADBEEF', null, 'method', 'DEADBEEF' ],

      'base-mixed-id' =>
        [ 'did:method:dEAdb33F', null, 'method', 'dEAdb33F' ],

      'empty-path' =>
        [ 'did:method:deadbeef/', 'did:method:deadbeef', 'method', 'deadbeef' ],

      'one-deep-path' =>
        [ 'did:method:deadbeef/abc', null, 'method', 'deadbeef', '/abc' ],

      'one-deep-path-trailing' =>
        [ 'did:method:deadbeef/abc/', 'did:method:deadbeef/abc', 'method', 'deadbeef', '/abc' ],

      'two-deep-path' =>
        [ 'did:method:deadbeef/abc/def/', 'did:method:deadbeef/abc/def', 'method', 'deadbeef', '/abc/def' ],

      'mixed-path' =>
        [ 'did:method:deadbeef/Camel/Case', null, 'method', 'deadbeef', '/Camel/Case' ],

      'pct-encoding' =>
        [ 'did:method:deadbeef/%3F%20%3E', null, 'method', 'deadbeef', '/%3F%20%3E' ],

      'strange-path' =>
        [ 'did:method:deadbeef/;this.is!a+strange~*(path)', null, 'method', 'deadbeef', '/;this.is!a+strange~*(path)'],

      'fragment' =>
        [ 'did:method:deadbeef#fragment', null, 'method', 'deadbeef', null, 'fragment' ],

      'path-fragment' =>
        [ 'did:method:deadbeef/abc#fragment', null, 'method', 'deadbeef', '/abc', 'fragment' ],

      'empty-path-fragment' =>
        [ 'did:method:deadbeef/#fragment', 'did:method:deadbeef#fragment', 'method', 'deadbeef', null, 'fragment' ],

      'uuid-fragment' =>
        [ 'did:method:deadbeef#0123-4567-89AB-CDEF', null, 'method', 'deadbeef', null, '0123-4567-89AB-CDEF' ],

      'strange-fragment' =>
        [ 'did:method:deadbeef/path;strange#a+strange~*)fragment(', null, 'method', 'deadbeef', '/path;strange', 'a+strange~*)fragment('],

      'base-multiple-ids' =>
        [ 'did:method:deadbeef:abcd1234', null, 'method', [ 'deadbeef', 'abcd1234' ] ],

      'base-multiple-ids-empty-path' =>
        [ 'did:method:deadbeef:abcd1234/', 'did:method:deadbeef:abcd1234', 'method', [ 'deadbeef', 'abcd1234' ] ],

      'base-multiple-ids-path' =>
        [ 'did:method:deadbeef:abcd1234:5c5c/def', null, 'method', [ 'deadbeef', 'abcd1234', '5c5c' ], '/def' ],

      'base-multiple-ids-fragment' =>
        [ 'did:method:deadbeef:abcd1234:5c5c#frag', null, 'method', [ 'deadbeef', 'abcd1234', '5c5c' ], null, 'frag' ],

      'base-multiple-ids-path-fragment' =>
        [ 'did:method:deadbeef:abcd1234:5c5c/def#frag', null, 'method', [ 'deadbeef', 'abcd1234', '5c5c' ], '/def', 'frag' ],
    ];
  }
}
