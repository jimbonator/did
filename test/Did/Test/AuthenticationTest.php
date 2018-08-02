<?php

namespace Did\Test;

require_once 'vendor/autoload.php';
require_once 'src/Did/Autoloader.php';
\Did\Autoloader::register();

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
