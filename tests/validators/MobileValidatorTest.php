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
        $this->assertTrue($val->validate('13311112222'));
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
        $this->assertTrue($val->validate('15611112222'));
        $this->assertTrue($val->validate('15711112222'));
        $this->assertTrue($val->validate('15811112222'));
        $this->assertTrue($val->validate('15911112222'));
        $this->assertTrue($val->validate('17055551234'));
        $this->assertTrue($val->validate('17155551234'));
        $this->assertTrue($val->validate('17255551234'));
        $this->assertTrue($val->validate('17355551234'));
        $this->assertTrue($val->validate('17455551234'));
        $this->assertTrue($val->validate('17555551234'));
        $this->assertTrue($val->validate('17655551234'));
        $this->assertTrue($val->validate('17755551234'));
        $this->assertTrue($val->validate('17855551234'));
        $this->assertTrue($val->validate('17955551234'));
        $this->assertTrue($val->validate('18055551234'));
        $this->assertTrue($val->validate('18155551234'));
        $this->assertTrue($val->validate('18255551234'));
        $this->assertTrue($val->validate('18355551234'));
        $this->assertTrue($val->validate('18455551234'));
        $this->assertTrue($val->validate('18555551234'));
        $this->assertTrue($val->validate('18655551234'));
        $this->assertTrue($val->validate('18755551234'));
        $this->assertTrue($val->validate('18855551234'));
        $this->assertTrue($val->validate('18955551234'));
        $this->assertFalse($val->validate('15166661'));
        $this->assertFalse($val->validate('151666612345'));
        $this->assertFalse($val->validate(null));
        $this->assertFalse($val->validate([]));

    }
}