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

namespace Exeu\ObjectMerger;

use Doctrine\Common\Annotations\AnnotationReader;
use Exeu\ObjectMerger\Metadata\Driver\AnnotationDriver;
use Metadata\MetadataFactory;

/**
 * Class ObjectMerger
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ObjectMerger
{
    public function merge($object1, $object2)
    {
        $visitor = $this->createMergingVisitor($object1);
        $visitor->visit($object1, $object2);
    }

    protected function createMergingVisitor($rootObject)
    {
        $reader = new AnnotationReader();
        $metadataDriver = new AnnotationDriver($reader);
        $metadataFactory = new MetadataFactory($metadataDriver);

        return new MergingVisitor($metadataFactory, $rootObject);
    }
}
