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

namespace Exeu\ObjectMerger\Test\Metadata\Driver;

use Doctrine\Common\Annotations\AnnotationReader;
use Exeu\ObjectMerger\Metadata\Driver\AnnotationDriver;

class AnnotationDriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotationDriver
     */
    protected $annotationDriver;

    protected function setUp()
    {
        $reader                  = new AnnotationReader();
        $this->annotationDriver  = new AnnotationDriver($reader);
    }

    public function testCorrectClassMetadata()
    {
        $reflection = new \ReflectionClass('Exeu\ObjectMerger\Test\Fixtures\SubObject');
        $classMetadata = $this->annotationDriver->loadMetadataForClass($reflection);

        $this->assertEquals('public_method', $classMetadata->accessor);
        $this->assertEquals(array('fullname'), $classMetadata->objectIdentifier);
        $this->assertEquals('Exeu\ObjectMerger\Test\Fixtures\SubObject', $classMetadata->name);
        $this->assertCount(3, $classMetadata->propertyMetadata);
    }

    public function testCorrectPropertyMetadata()
    {

    }

    protected function tearDown()
    {
        unset($this->annotationDriver);
    }
}
 