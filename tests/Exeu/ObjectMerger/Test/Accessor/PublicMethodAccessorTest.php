<?php
/*
 * Copyright 2014 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Exeu\ObjectMerger\Test\Accessor;

use Exeu\ObjectMerger\Accessor\PublicMethodAccessor;
use Exeu\ObjectMerger\Test\Fixtures\SubObject;

class PublicMethodAccessorTest extends \PHPUnit_Framework_TestCase
{
    protected $accessor;

    protected $object;

    protected function setUp()
    {
        $this->accessor = new PublicMethodAccessor();
        $this->object   = new SubObject();

        $this->object->setFullname('ABC');
    }

    public function testGetValue()
    {
        $reflectionClass   = new \ReflectionClass($this->object);
        $reflectionPropery = $reflectionClass->getProperty('fullname');

        $value = $this->accessor->getValue($reflectionPropery, $this->object);

        $this->assertEquals('ABC', $value);
    }

    public function testSetValue()
    {
        $reflectionClass   = new \ReflectionClass($this->object);
        $reflectionPropery = $reflectionClass->getProperty('fullname');

        $this->accessor->setValue($reflectionPropery, $this->object, 'DEF');

        $this->assertEquals('DEF', $this->object->getFullname());
    }

    /**
     * @expectedException ReflectionException
     * @expectedExceptionMessage Property foo does not exist
     */
    public function testSetInvalidProperty()
    {
        $reflectionClass   = new \ReflectionClass($this->object);
        $reflectionPropery = $reflectionClass->getProperty('foo');

        $this->accessor->setValue($reflectionPropery, $this->object, 'DEF');

        $this->assertEquals('DEF', $this->object->getFullname());
    }

    /**
     * @expectedException ReflectionException
     * @expectedExceptionMessage Property foo does not exist
     */
    public function testGetInvalidProperty()
    {
        $reflectionClass   = new \ReflectionClass($this->object);
        $reflectionPropery = $reflectionClass->getProperty('foo');

        $this->accessor->getValue($reflectionPropery, $this->object);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage No setter found for "noGetterAndSetter"
     */
    public function testNoSetter()
    {
        $reflectionClass   = new \ReflectionClass($this->object);
        $reflectionPropery = $reflectionClass->getProperty('noGetterAndSetter');

        $this->accessor->setValue($reflectionPropery, $this->object, 'DEF');

        $this->assertEquals('DEF', $this->object->getFullname());
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage No getter found for "noGetterAndSetter"
     */
    public function testNoGetter()
    {
        $reflectionClass   = new \ReflectionClass($this->object);
        $reflectionPropery = $reflectionClass->getProperty('noGetterAndSetter');

        $this->accessor->getValue($reflectionPropery, $this->object);
    }
}
 