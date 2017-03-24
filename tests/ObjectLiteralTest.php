<?php

namespace Tests\ObjectLiteral;

use Exception;
use InvalidArgumentException;
use ObjectLiteral\Object;
use Tests\ObjectLiteral\fixtures\ObjectTriggersExceptionInsteadOfError;

final class ObjectLiteralShould extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function
    create_an_empty_object_from_empty_value()
    {
        $object = new Object();
        $this->assertInstanceOf(Object::class, $object);
        $this->assertEmpty(get_object_vars($object));
    }

    /**
     * @test
     * @dataProvider invalidValuesToCreateObjectFrom
     * @expectedException InvalidArgumentException
     * @param $invalidValue
     */
    public function
    should_not_create_an_object_from_invalid_values($invalidValue)
    {
        new Object($invalidValue);
    }

    public function invalidValuesToCreateObjectFrom()
    {
        $anyIntegerGreaterThan0 = 1;
        $invalidJson1 = "{ 'bar': 'baz' }";
        $invalidJson2 = '{ bar: "baz" }';
        $invalidJson3 = '{ bar: "baz", }';

        return [
            [$anyIntegerGreaterThan0],
            [$invalidJson1],
            [$invalidJson2],
            [$invalidJson3],
        ];
    }

    /** @test */
    public function
    create_an_object_from_array_with_array_values_as_properties()
    {
        $object = new Object([
            "name" => "Fido",
            "barks" => true,
            "age" => 10
        ]);

        $expectedObject = new Object();
        $expectedObject->name = 'Fido';
        $expectedObject->barks = true;
        $expectedObject->age = 10;

        $this->assertEquals($expectedObject, $object);
    }

    /** @test */
    public function
    create_an_object_from_array_with_callable_properties()
    {
        $object = new Object([
            "name" => "Fido",
            "barks" => true,
            "age" => 10,
            'say' => function ($self) {
                if ($self->barks) {
                    return "Woof";
                }
                return "";
            }
        ]);

        $this->assertInstanceOf(Object::class, $object);
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertEquals("Woof", $object->say());
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Not callable property: nonCallableProperty
     */
    public function
    should_trigger_an_error_when_not_callable_property_is_trying_to_be_called()
    {
        $object = new ObjectTriggersExceptionInsteadOfError();
        /** @noinspection PhpUndefinedMethodInspection */
        $object->nonCallableProperty();
    }

    /** @test */
    public function
    create_an_object_from_nested_arrays_with_array_values_as_properties()
    {
        $object = new Object([
            "name" => "Fido",
            "barks" => true,
            "age" => 10,
            "nestedObject" => [
                "name" => "Fido2",
                "barks" => false,
                "age" => 5
            ]
        ]);

        $expectedObject = new Object();
        $expectedObject->name = 'Fido';
        $expectedObject->barks = true;
        $expectedObject->age = 10;
        $expectedObject->nestedObject = new Object();
        $expectedObject->nestedObject->name = 'Fido2';
        $expectedObject->nestedObject->barks = false;
        $expectedObject->nestedObject->age = 5;

        $this->assertEquals($expectedObject, $object);
    }

    /** @test */
    public function
    create_an_object_from_json()
    {
        $object = new Object('{
            "name" : "Fido",
            "barks" : true,
            "age" : 10
        }');

        $expectedObject = new Object();
        $expectedObject->name = 'Fido';
        $expectedObject->barks = true;
        $expectedObject->age = 10;

        $this->assertEquals($expectedObject, $object);
    }

    /** @test */
    public function
    create_an_object_from_json_with_dynamic_keys()
    {
        $keyForName = 'name';
        $object = new Object("{
            \"" . $keyForName . "\" : \"Fido\",
            \"barks\" : true,
            \"age\" : 10
        }");

        $expectedObject = new Object();
        $expectedObject->name = 'Fido';
        $expectedObject->barks = true;
        $expectedObject->age = 10;

        $this->assertEquals($expectedObject, $object);
    }

    /** @test */
    public function
    create_an_object_from_json_with_dynamic_values()
    {
        $valueForName = 'Fido';
        $object = new Object("{
            \"name\" : \"" . $valueForName . "\",
            \"barks\" : true,
            \"age\" : 10
        }");

        $expectedObject = new Object();
        $expectedObject->name = 'Fido';
        $expectedObject->barks = true;
        $expectedObject->age = 10;

        $this->assertEquals($expectedObject, $object);
    }
}