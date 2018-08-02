<?php

namespace Did\Test;

require_once 'vendor/autoload.php';
require_once 'src/Did/Autoloader.php';
\Did\Autoloader::register();

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
