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

namespace Exeu\ObjectMerger\Test;

use Exeu\ObjectMerger\Test\Fixtures\ObjectC;
use Exeu\ObjectMerger\Test\Fixtures\ObjectD;
use Exeu\ObjectMerger\Test\Fixtures\SubObject;

class FirstLevelMergeTest extends BaseMergeTest
{
    /**
     * @dataProvider provideObjectGraph
     */
    public function testFirstLevelStringMerge($objectA, $objectAA)
    {
        $expectedName   = $objectA->getName();
        $expectedStreet = $objectA->getStreet();

        $this->assertNotEquals($expectedName, $objectAA->getName());
        $this->assertNotEquals($expectedStreet, $objectAA->getStreet());

        $this->objectMerger->merge($objectA, $objectAA);

        $this->assertEquals($expectedName, $objectAA->getName());
        $this->assertEquals($expectedStreet, $objectAA->getStreet());
    }

    /**
     * @dataProvider provideObjectGraph
     */
    public function testFirstLevelBooleanMerge($objectA, $objectAA)
    {
        $expectedBool = $objectA->getBool();

        $this->assertNotEquals($expectedBool, $objectAA->getBool());

        $this->objectMerger->merge($objectA, $objectAA);

        $this->assertEquals($expectedBool, $objectAA->getBool());
    }

    /**
     * @dataProvider provideObjectGraph
     */
    public function testFirstLevelObjectMerge($objectA, $objectAA)
    {
        $subjectA  = $objectA->getObj();
        $subjectAA = $objectAA->getObj();

        $expectedName = $subjectA->getFullname();
        $expectedBool = $subjectA->getIgnored();

        $this->assertNotEquals($expectedName, $subjectAA->getFullname());
        $this->assertNotEquals($expectedBool, $subjectAA->getIgnored());

        $this->objectMerger->merge($objectA, $objectAA);

        $this->assertEquals($expectedName, $subjectAA->getFullname());
        $this->assertEquals($expectedBool, $subjectAA->getIgnored());
    }

    /**
     * @dataProvider provideFlatObject
     */
    public function testFirstLevelNoPropertyMerge(SubObject $objectA, SubObject $objectAA)
    {
        $this->assertNotEquals($objectA->getNotMergeable(), $objectAA->getNotMergeable());

        $this->objectMerger->merge($objectA, $objectAA);

        $this->assertNotEquals($objectA->getNotMergeable(), $objectAA->getNotMergeable());
    }

    public function testIgnoreNullValue()
    {
        $objectA = new ObjectD();
        $objectB = new ObjectD();

        $objectA->fullname = null;
        $objectB->fullname = 'NoNullValue';

        $this->objectMerger->merge($objectA, $objectB);

        $this->assertEquals('NoNullValue', $objectB->fullname);
    }
} 