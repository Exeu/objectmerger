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

use Exeu\ObjectMerger\Accessor\PublicMethodAccessor;
use Exeu\ObjectMerger\Accessor\ReflectionAccessor;
use Exeu\ObjectMerger\Metadata\PropertyMetadata;
use Metadata\ClassHierarchyMetadata;

class MergeContext
{
    private $metadata;

    private $mergingVisitor;

    private $object1;

    private $object2;

    private $propertyAccessor;

    public function __construct(ClassHierarchyMetadata $metadata, MergingVisitor $mergingVisitor, $object1, $object2)
    {
        $this->metadata = $metadata->getRootClassMetadata();
        $this->mergingVisitor = $mergingVisitor;
        $this->object1 = $object1;
        $this->object2 = $object2;

        switch ($this->metadata->accessor) {
            case 'public_method':
                $this->propertyAccessor = new PublicMethodAccessor();
                break;
            case 'reflection':
            default:
                $this->propertyAccessor = new ReflectionAccessor();
                break;
        }
    }

    public function merge()
    {
        foreach ($this->metadata->propertyMetadata as $comparableProperty) {
            /** @var PropertyMetadata $comparableProperty */
            switch ($comparableProperty->type) {
                case 'string':
                    $this->mergeString($comparableProperty->reflection);
                    break;
                case 'object':
                    $this->mergeObject($comparableProperty->reflection);
                    break;
                case 'boolean':
                    $this->mergeBoolean($comparableProperty->reflection);
                    break;
                case 'Collection':
                    $this->mergeCollection($comparableProperty);
                    break;
            }
        }
    }

    protected function mergeCollection($property)
    {
        $objectIdentifier        = $property->objectIdentifier;
        $reflectionProperty      = $property->reflection;
        $collectionMergeStrategy = $property->collectionMergeStrategy;

        $dominatingObjectCollection = $reflectionProperty->getValue($this->object1);
        $mergeableObjectCollection  = $reflectionProperty->getValue($this->object2);

        $missingValues = array();

        foreach ($dominatingObjectCollection as $singleDominatingObject) {
            $reflectionClass   = new \ReflectionClass($singleDominatingObject);

            $comparsionIdentifier = $reflectionClass->getProperty($objectIdentifier);
            $comparsionIdentifier->setAccessible(true);
            $comparsionIdentifierValue = $comparsionIdentifier->getValue($singleDominatingObject);

            foreach ($mergeableObjectCollection as $mergeableObject) {
                $mergeableObjectComparsionIdentifierValue = $comparsionIdentifier->getValue($mergeableObject);

                if ($comparsionIdentifierValue == $mergeableObjectComparsionIdentifierValue) {
                    $this->mergingVisitor->visit($singleDominatingObject, $mergeableObject);
                    continue 2;
                }
            }

            array_push($missingValues, $singleDominatingObject);
        }

        if ($collectionMergeStrategy === 'addMissing') {
            foreach ($missingValues as $missingValue) {
                $mergeableObjectCollection[] = $missingValue;
            }

            $this->propertyAccessor->setValue(
                $reflectionProperty,
                $this->object2,
                $mergeableObjectCollection
            );
        }
    }

    protected function mergeBoolean(\ReflectionProperty $property)
    {
        $this->propertyAccessor->setValue(
            $property,
            $this->object2,
            (boolean) $this->propertyAccessor->getValue($property, $this->object1)
        );
    }

    protected function mergeString(\ReflectionProperty $property)
    {
        $this->propertyAccessor->setValue(
            $property,
            $this->object2,
            (string) $this->propertyAccessor->getValue($property, $this->object1)
        );
    }

    protected function mergeObject(\ReflectionProperty $property)
    {
        $this->mergingVisitor->visit($property->getValue($this->object1), $property->getValue($this->object2));
    }
} 