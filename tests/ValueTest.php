<?php

use Mockery as m;
use Devio\Propertier\Value;
use Devio\Propertier\Factory;
use Devio\Propertier\Property;
use Devio\Propertier\Values\StringValue;
use Devio\Propertier\Values\IntegerValue;

class ValueTest extends PHPUnit_Framework_TestCase
{
    public function tearDown() {
        m::close();
    }

    /** @test */
    public function it_should_make_a_casted_value()
    {
        $value = Value::make(new Property(['type' => 'string']), 'foo');

        $this->assertInstanceOf(StringValue::class, $value);
    }

    /** @test */
    public function it_should_make_a_value_with_property_and_array()
    {
        $value = Value::make(new Property(['type' => 'string']), ['value' => 'foo']);

        $this->assertEquals('foo', $value->getAttribute('value'));
    }

    /** @test */
    public function it_should_make_a_value_with_property_and_string()
    {
        $value = Value::make(new Property(['type' => 'string']), 'foo');

        $this->assertEquals('foo', $value->getAttribute('value'));
    }

    /** @test */
    public function it_should_cast_a_value_object()
    {
        $factory = m::mock(Factory::class);
        $value = new Value();
        $value->setFactory($factory);
        $property = new Property(['type' => 'integer']);

        $factory->shouldReceive('property')->twice()->andReturn(IntegerValue::class);

        $this->assertInstanceOf(IntegerValue::class, $value->castObjectTo($property));
        $this->assertEquals($value->getAttributes(), $value->castObjectTo($property)->getAttributes());
    }

    /** @test */
    public function it_should_not_cast_casted_value()
    {
        $value = new StringValue();
        $property = new Property(['type' => 'integer']);

        $this->assertInstanceOf(StringValue::class, $value->castObjectTo($property));
    }
}