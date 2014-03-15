<?php
/*
 * Copyright 2013 Jan Eichhorn <exeu65@googlemail.com>
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

namespace Exeu\ObjectComparer;

use Doctrine\Common\Annotations\AnnotationReader;
use Exeu\ObjectComparer\Metadata\Driver\AnnotationDriver;
use Exeu\ObjectComparer\Visitor\ObjectVisitor;
use Metadata\MetadataFactory;

/**
 * Class ObjectComparer
 *
 * @package Exeu\ObjectComparer
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ObjectComparer
{
    protected $objectVisitor;

    public function __construct()
    {
        $this->objectVisitor = new ObjectVisitor();
    }

    public function compare($object1, $object2)
    {
        $this->objectVisitor->visit($object1, $object2, $metadata);
    }
}
