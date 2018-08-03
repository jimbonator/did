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
use Did\PublicKey;
use Did\PublicKeyValue;
use Did\Uri;

/**
 *
 */
class AuthenticationTest extends TestCase {
  const TYPE = 'FakeSig2018';

  public function testCreateEmpty() {
    $authn = new Authentication();

    $this->assertNull($authn->type());
    $this->assertNull($authn->publicKey());
    $this->assertFalse($authn->isReference());
    $this->assertFalse($authn->isEmbedded());
  }

  public function testCreateEmbedded() {
    $pk = new PublicKey(
      Uri::parse('did:method:key'),
      static::TYPE,
      new PublicKeyValue(PublicKeyValue::PK_PEM, 'deadbeef')
    );
    $authn = new Authentication(static::TYPE, $pk);

    $this->assertSame(static::TYPE, $authn->type());
    $this->assertSame($pk, $authn->publicKey());
    $this->assertFalse($authn->isReference());
    $this->assertTrue($authn->isEmbedded());
  }

  public function testCreateReference() {
    $authn = new Authentication(static::TYPE, Uri::parse('did:method:key'));

    $this->assertSame(static::TYPE, $authn->type());
    $this->assertSame('did:method:key', $authn->publicKey()->encode());
    $this->assertTrue($authn->isReference());
    $this->assertFalse($authn->isEmbedded());
  }
}
