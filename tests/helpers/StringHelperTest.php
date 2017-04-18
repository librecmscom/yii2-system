<?php
namespace tests\helpers;

use Yii;
use tests\TestCase;
use yuncms\system\helpers\StringHelper;

/**
 * StringHelper test
 */
class StringHelperTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testSubstr()
    {
        $a = StringHelper::substr('abcdefg', 0, 3);
        $this->assertEquals('abc', $a);
        $b = StringHelper::substr('我是中国人', 0, 9);
        $this->assertEquals('我是中', $b);
    }

    public function testBetweenSubstr()
    {
        $a = StringHelper::betweenSubstr('abcdefg', 'a', 'e');
        $this->assertEquals('bcd', $a);
    }
}

