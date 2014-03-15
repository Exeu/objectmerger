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

use Metadata\MetadataFactory;

class MergingVisitor
{
    protected $visitedObjects = array();

    private $metadataFactory;

    private $rootObject;

    public function __construct(MetadataFactory $metadataFactory, $rootObject)
    {
        $this->metadataFactory = $metadataFactory;
        $this->rootObject = $rootObject;
    }

    public function visit($object1, $object2)
    {
        if (get_class($object1) !== get_class($object2)) {
            return;
        }

        $objectMetadata = $this->metadataFactory->getMetadataForClass(get_class($object1));

        if (isset($this->visitedObjects[spl_object_hash($object1)])) {
            return;
        }

        $this->visitedObjects[spl_object_hash($object1)] = true;

        $executionContext = new MergeContext($objectMetadata, $this, $object1, $object2);
        $executionContext->merge();
    }
} 