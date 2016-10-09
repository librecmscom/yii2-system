<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace tests\validators;

use tests\TestCase;
use yuncms\system\validators\MobileValidator;

class MobileValidatorTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }

    public function testValidateValue()
    {
        $val = new MobileValidator;
        $this->assertTrue($val->validate('13011112222'));
        $this->assertTrue($val->validate('13111112222'));
        $this->assertTrue($val->validate('13211112222'));
        $this->assertTrue($val->validate('13111112222'));
        $this->assertTrue($val->validate('13411112222'));
        $this->assertTrue($val->validate('13511112222'));
        $this->assertTrue($val->validate('13611112222'));
        $this->assertTrue($val->validate('13711112222'));
        $this->assertTrue($val->validate('13811112222'));
        $this->assertTrue($val->validate('13911112222'));
        $this->assertTrue($val->validate('15011112222'));
        $this->assertTrue($val->validate('15111112222'));
        $this->assertTrue($val->validate('15211112222'));
        $this->assertTrue($val->validate('15311112222'));
        $this->assertTrue($val->validate('15411112222'));
        $this->assertTrue($val->validate('15511112222'));
        $this->assertTrue($val->validate('17855551234'));
        $this->assertTrue($val->validate('18855551234'));
        $this->assertFalse($val->validate('15166661'));
        $this->assertFalse($val->validate('151666612345'));
        $this->assertFalse($val->validate(null));
        $this->assertFalse($val->validate([]));

    }
}