<?php

namespace Did\Test;

require_once 'vendor/autoload.php';
require_once 'src/Did/Autoloader.php';
\Did\Autoloader::register();

use Did\Timestamp;

/**
 *
 */
class TimestampTest extends TestCase {
  public function testDefaultCtor() {
    $ts = new Timestamp();

    $this->assertTrue(is_int($ts->time_t()));
    $this->assertTrue($ts->time_t() > 0);
  }

  public function testCtor() {
    $ts = new Timestamp(1);

    $this->assertSame(1, $ts->time_t());
  }

  public function testEncode() {
    $ts = new Timestamp(1);

    $this->assertSame('1970-01-01T00:00:01Z', $ts->encode());
  }
}
