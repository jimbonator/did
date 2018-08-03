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
