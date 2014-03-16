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

use Exeu\ObjectMerger\Metadata\PropertyMetadata;

/**
 * Class MergingVisitor
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class MergingVisitor
{
    /**
     * Merges a collection of objects.
     *
     * @param PropertyMetadata $property Metadata of the property
     * @param MergeContext     $context  The current mergingcontext
     */
    public function mergeCollection(PropertyMetadata $property, MergeContext $context)
    {
        $objectIdentifier        = $property->objectIdentifier;
        $reflectionProperty      = $property->reflection;
        $collectionMergeStrategy = $property->collectionMergeStrategy;

        $dominatingObjectCollection = $reflectionProperty->getValue($context->getMergeFrom());
        $mergeableObjectCollection  = $reflectionProperty->getValue($context->getMergeTo());

        $missingValues = array();

        foreach ($dominatingObjectCollection as $singleDominatingObject) {
            $reflectionClass   = new \ReflectionClass($singleDominatingObject);

            $comparsionIdentifier = $reflectionClass->getProperty($objectIdentifier);
            $comparsionIdentifier->setAccessible(true);
            $comparsionIdentifierValue = $comparsionIdentifier->getValue($singleDominatingObject);

            foreach ($mergeableObjectCollection as $mergeableObject) {
                $mergeableObjectComparsionIdentifierValue = $comparsionIdentifier->getValue($mergeableObject);

                if ($comparsionIdentifierValue == $mergeableObjectComparsionIdentifierValue) {
                    $context->getGraphWalker()->accept($singleDominatingObject, $mergeableObject);
                    continue 2;
                }
            }

            array_push($missingValues, $singleDominatingObject);
        }

        if ($collectionMergeStrategy === 'addMissing') {
            foreach ($missingValues as $missingValue) {
                $mergeableObjectCollection[] = $missingValue;
            }

            $context->getPropertyAccessor()->setValue(
                $reflectionProperty,
                $context->getMergeTo(),
                $mergeableObjectCollection
            );
        }
    }

    /**
     * Merges a simple boolean property.
     *
     * @param PropertyMetadata $property Metadata of the property
     * @param MergeContext     $context  The current mergingcontext
     */
    public function mergeBoolean(PropertyMetadata $property, MergeContext $context)
    {
        $reflectionProperty = $property->reflection;

        $context->getPropertyAccessor()->setValue(
            $reflectionProperty,
            $context->getMergeTo(),
            (boolean) $context->getPropertyAccessor()->getValue($reflectionProperty, $context->getMergeFrom())
        );
    }

    /**
     * Merges a simple string property.
     *
     * @param PropertyMetadata $property Metadata of the property
     * @param MergeContext     $context  The current mergingcontext
     */
    public function mergeString(PropertyMetadata $property, MergeContext $context)
    {
        $reflectionProperty = $property->reflection;

        $context->getPropertyAccessor()->setValue(
            $reflectionProperty,
            $context->getMergeTo(),
            (string) $context->getPropertyAccessor()->getValue($reflectionProperty, $context->getMergeFrom())
        );
    }

    /**
     * Merges an object property.
     *
     * @param PropertyMetadata $property Metadata of the property
     * @param MergeContext     $context  The current mergingcontext
     */
    public function mergeObject(PropertyMetadata $property, MergeContext $context)
    {
        $reflectionProperty = $property->reflection;

        $context->getGraphWalker()->accept(
            $reflectionProperty->getValue($context->getMergeFrom()),
            $reflectionProperty->getValue($context->getMergeTo())
        );
    }
}
