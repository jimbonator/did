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

use Did\PublicKey;
use Did\PublicKeyValue;
use Did\Uri;

/**
 *
 */
class PublicKeyTest extends TestCase {
  private $uri;
  private $pkv;

  protected function setUp() {
    parent::setUp();

    $this->uri = new Uri('method', 'abcdef');
    $this->pkv = new PublicKeyValue(PublicKeyValue::PK_PEM, 'deadbeef');
  }

  public function testCreate() {
    $pk = new PublicKey($this->uri, 'FakeSignature', $this->pkv);

    $this->assertSame($this->uri, $pk->id());
    $this->assertSame('FakeSignature', $pk->type());
    $this->assertSame($this->pkv, $pk->value());
  }

  public function testOwner() {
    $pk = new PublicKey($this->uri, 'FakeSig', $this->pkv);
    $this->assertNull($pk->owner());

    $pk->setOwner($this->uri);
    $this->assertSame($this->uri, $pk->owner());
  }
}
