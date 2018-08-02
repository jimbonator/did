<?php

namespace Did\Test;

require_once 'vendor/autoload.php';
require_once 'src/Did/Autoloader.php';
\Did\Autoloader::register();

use Did\PublicKeyValue;

/**
 *
 */
class PublicKeyValueTest extends TestCase {
  public function testCreate() {
    $pkv = new PublicKeyValue(PublicKeyValue::PK_PEM, 'deadbeef');

    $this->assertSame(PublicKeyValue::PK_PEM, $pkv->name());
    $this->assertSame('deadbeef', $pkv->value());
  }
}
