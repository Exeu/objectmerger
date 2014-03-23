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

use Doctrine\Common\Annotations\AnnotationReader;
use Exeu\ObjectMerger\Accessor\PropertyAccessorRegistry;
use Exeu\ObjectMerger\EventDispatcher\EventDispatcher;
use Exeu\ObjectMerger\MergeHandler\MergeHandlerRegistry;
use Exeu\ObjectMerger\Metadata\Driver\AnnotationDriver;
use Exeu\ObjectMerger\ObjectMerger;
use Metadata\MetadataFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Exeu\ObjectMerger\Test\Fixtures\ObjectA;
use Exeu\ObjectMerger\Test\Fixtures\ObjectB;
use Exeu\ObjectMerger\Test\Fixtures\SubObject;

abstract class BaseMergeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectMerger
     */
    protected $objectMerger;

    protected function setUp()
    {
        $reader  = new AnnotationReader();
        $driver  = new AnnotationDriver($reader);

        $metadataFactory          = new MetadataFactory($driver);
        $eventDispatcher          = new EventDispatcher();
        $propertyAccessorRegistry = new PropertyAccessorRegistry();
        $mergeHanlderRegistry     = new MergeHandlerRegistry();

        $this->objectMerger = new ObjectMerger($metadataFactory, $propertyAccessorRegistry, $mergeHanlderRegistry, $eventDispatcher);
    }

    public function provideFlatObject()
    {
        $testA   = new SubObject();
        $testA->setFullname('HansImWald');
        $testA->setIgnored(false);
        $testA->setNotMergeable('NOT');

        $testAA   = new SubObject();
        $testAA->setFullname('ReinerImWald');
        $testAA->setIgnored(true);
        $testAA->setNotMergeable('MERGEABLE');

        return array(
            array($testA, $testAA)
        );
    }

    public function provideObjectGraph()
    {
        $objectA = new ObjectA();
        $objectB = new ObjectB();
        $objectC = new ObjectB();
        $testA   = new SubObject();

        $testA->setFullname('HansImWald');
        $testA->setIgnored(false);

        $objectA->setId(1);
        $objectA->setName('Jan');
        $objectA->setStreet('blubb');
        $objectA->setBool(true);

        $objectB->setId(1111);
        $objectB->setFullname('Jhon');
        $objectB->setIgnored(false);

        $objectC->setId(13);
        $objectC->setFullname('Jhan2');
        $objectC->setIgnored(true);

        $coll = new ArrayCollection();
        $coll->add($objectB);
        $coll->add($objectC);

        $objectA->setFriends($coll);
        $objectA->setObj($testA);

        $objectAA = new ObjectA();
        $objectBB = new ObjectB();
        $objectCC = new ObjectB();
        $testAA   = new SubObject();

        $testAA->setFullname('ReinerImWald');
        $testAA->setIgnored(true);

        $objectAA->setId(1);
        $objectAA->setName('Jan22');
        $objectAA->setStreet('blabb');
        $objectAA->setBool(false);

        $objectBB->setId(12);
        $objectBB->setFullname('Jhon2');
        $objectBB->setIgnored(true);

        $objectCC->setId(13);
        $objectCC->setFullname('Jhan');
        $objectCC->setIgnored(false);

        $coll2 = new ArrayCollection();
        $coll2->add($objectBB);
        $coll2->add($objectCC);

        $objectAA->setFriends($coll2);
        $objectAA->setObj($testAA);

        return array(
            array($objectA, $objectAA)
        );
    }

    protected function tearDown()
    {

    }
}
 