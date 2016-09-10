<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Get a protected/private property of a class
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $property Property to get
     *
     * @return mixed Method return.
     */
    public function getProperty(&$object, $property)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * Set a protected/private property of a class
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $property Property to set
     * @param string $value Value to set
     *
     * @return mixed Method return.
     */
    public function setProperty(&$object, $property, $value)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($object, $value);
    }
}