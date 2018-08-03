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

use Did\Authentication;
use Did\Document;
use Did\PublicKey;
use Did\PublicKeyValue;
use Did\Timestamp;
use Did\Uri;
use Did\Util\Json;

/**
 *
 */
class DocumentTest extends TestCase {
  private $uri;

  protected function setUp() {
    parent::setUp();

    $this->uri = new Uri('method', 'deadbeef');
  }

  //
  // tests
  //

  public function testBasicEncode() {
    $doc = new Document($this->uri);

    $expected = [ '@context' => Document::DEFAULT_CONTEXT, 'id' => $this->uri->encode() ];

    $this->assertSame(json_encode($expected), json_encode($doc));
  }

  public function testHas() {
    $doc = new Document($this->uri);

    // default values
    $this->assertTrue($doc->has('@context'));
    $this->assertTrue($doc->has('id'));
    $this->assertTrue(isset($doc['id']));
  }

  public function testGet() {
    $doc = new Document($this->uri);

    $this->assertSame($doc->get('@context'), Document::DEFAULT_CONTEXT);
    $this->assertSame($doc['@context'], Document::DEFAULT_CONTEXT);
  }

  public function testSet() {
    $doc = new Document($this->uri);
    $doc->set('blockchain', 'deadbeef');

    $this->assertTrue(isset($doc['blockchain']));
    $this->assertSame($doc->get('blockchain'), 'deadbeef');
  }

  public function testSetClear() {
    $doc = new Document($this->uri);
    $doc->set('blockchain', 'deadbeef');
    $doc->set('blockchain', null);

    $this->assertFalse(isset($doc['blockchain']));
  }

  public function testClear() {
    $doc = new Document($this->uri);
    $doc['blockchain'] = 'yes';
    $doc['profile'] = 'yes';

    $this->assertTrue($doc->has('blockchain'));
    $this->assertTrue(isset($doc['profile']));

    $doc->remove('blockchain');
    $this->assertFalse(isset($doc['blockchain']));

    unset($doc['profile']);
    $this->assertFalse($doc->has('profile'));
  }

  public function testGetters() {
    $doc = new Document($this->uri);

    $this->assertSame($doc['@context'], $doc->context());
    $this->assertSame($doc['id'], $doc->subject());
  }

  /**
   * @dataProvider provideTimestampMethods
   */
  public function testTimestamps($getter) {
    $doc = new Document($this->uri);

    $this->assertNull($doc->$getter());
    $setter = "set$getter";
    $doc->$setter();
    $this->assertTrue($doc->$getter() instanceof Timestamp);
  }

  public function provideTimestampMethods() {
    return [
      'created' =>  [ 'created' ],
      'updated' =>  [ 'updated' ],
    ];
  }

  /**
   * @dataProvider providePublicKey
   */
  public function testPublicKey($pks) {
    $doc = new Document($this->uri);
    $this->assertNull($doc->publicKey());

    $doc->setPublicKey($pks);

    if (isset($pks) && !empty($pks))
      $this->assertSame((array) $pks, $doc->publicKey());
    else
      $this->assertNull($doc->publicKey());
  }

  public function providePublicKey() {
    $one = new PublicKey(
      new Uri('method', 'deadbeef'),
      'FakeSigA',
      new PublicKeyValue(PublicKeyValue::PK_PEM, 'deadbeef')
    );

    $two = new PublicKey(
      new Uri('method', 'deadbeef'),
      'FakeSigB',
      new PublicKeyValue(PublicKeyValue::PK_HEX, 'deadbeef')
    );

    return [
      'null' =>           [ null ],
      'empty' =>          [ [] ],
      'single' =>         [ $one ],
      'multiple' =>       [ [ $one, $two ] ],
    ];
  }

  /**
   * @dataProvider provideAuthentication
   */
  public function testAuthentication($authn) {
    $doc = new Document($this->uri);
    $this->assertNull($doc->authentication());

    $doc->setAuthentication($authn);

    if (isset($authn) && !empty($authn))
      $this->assertSame((array) $authn, $doc->authentication());
    else
      $this->assertNull($doc->authentication());
  }

  public function provideAuthentication() {
    $one = new Authentication('FakeSigOne', $this->uri);
    $two = new Authentication('FakeSigTwo', $this->uri);

    return [
      'null' =>           [ null ],
      'empty' =>          [ [] ],
      'single' =>         [ $one ],
      'multiple' =>       [ [ $one, $two ] ],
    ];
  }
}
