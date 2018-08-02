<?php

namespace Did\Test;

require_once 'vendor/autoload.php';
require_once 'src/Did/Autoloader.php';
\Did\Autoloader::register();

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
      'empty' =>          [ [] ],
      'single' =>         [ $one ],
      'multiple' =>       [ [ $one, $two ] ],
    ];
  }
}
