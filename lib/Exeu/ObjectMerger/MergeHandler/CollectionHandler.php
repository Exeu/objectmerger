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

namespace Exeu\ObjectMerger\MergeHandler;

use Exeu\ObjectMerger\Annotation\Mergeable;
use Exeu\ObjectMerger\Exception\MergeException;
use Exeu\ObjectMerger\MergeContext;
use Exeu\ObjectMerger\MergeHandlerInterface;
use Exeu\ObjectMerger\MergeStrategy\AddMissing;
use Exeu\ObjectMerger\Metadata\PropertyMetadata;

/**
 * The Collectionhandler merges two objectcollections.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class CollectionHandler implements MergeHandlerInterface
{
    /**
     * @var array
     */
    protected $mergeStrategies = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->mergeStrategies[Mergeable::MERGE_STRATEGY_ADD_MISSING] = new AddMissing();
    }

    /**
     * {@inheritDoc}
     *
     * @TODO This mehtod needs to be refactored.
     */
    public function merge(PropertyMetadata $propertyMetadata, MergeContext $context)
    {
        $innerType          = $propertyMetadata->innerType;
        $reflectionProperty = $propertyMetadata->reflection;

        if (!$innerType) {
            throw new MergeException('You must provide an inner type.');
        }

        $reflectionClass    = new \ReflectionClass($innerType);
        $innerClassMetadata = $context->getGraphWalker()->getMetadataFactory()->getMetadataForClass($innerType);
        $objectIdentifier   = $innerClassMetadata->objectIdentifier;

        if ($objectIdentifier === null) {
            throw new MergeException('You must provide at least one identifier field.');
        }

        $sourceCollection = $reflectionProperty->getValue($context->getMergeFrom());
        $targetCollection = $reflectionProperty->getValue($context->getMergeTo());

        $collectedValues = array('missing' => array(), 'removed' => array());
        foreach ($sourceCollection as $sourceItem) {
            foreach ($targetCollection as $targetItem) {
                if ($this->isMergeable($objectIdentifier, $reflectionClass, $sourceItem, $targetItem)) {
                    $context->getGraphWalker()->accept($sourceItem, $targetItem);
                    continue 2;
                }
            }

            array_push($collectedValues['missing'], $sourceItem);
        }

        $this->applyCollectionMergeStrategy($propertyMetadata, $collectedValues, $context);
    }

    /**
     * @param array            $objectIdentifier
     * @param \ReflectionClass $reflectionClass
     * @param object           $sourceItem
     * @param object           $targetItem
     *
     * @return bool
     */
    protected function isMergeable(array $objectIdentifier, \ReflectionClass $reflectionClass, $sourceItem, $targetItem)
    {
        foreach ($objectIdentifier as $key) {
            $comparsionIdentifier = $reflectionClass->getProperty($key);
            $comparsionIdentifier->setAccessible(true);

            $sourceValue    = $comparsionIdentifier->getValue($sourceItem);
            $mergeableValue = $comparsionIdentifier->getValue($targetItem);

            if ($sourceValue != $mergeableValue) {
                return false;
            }
        }

        return true;
    }

    /**
     * Applies a merge strategy if it is registered.
     *
     * @param PropertyMetadata $propertyMetadata
     * @param array            $collectedValues
     * @param MergeContext     $context
     */
    protected function applyCollectionMergeStrategy(PropertyMetadata $propertyMetadata, array $collectedValues, MergeContext $context)
    {
        $collectionMergeStrategy = $propertyMetadata->collectionMergeStrategy;

        if (!isset($this->mergeStrategies[$collectionMergeStrategy])) {
            return;
        }

        $this->mergeStrategies[$collectionMergeStrategy]->apply($propertyMetadata, $collectedValues, $context);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return 'Collection';
    }
}
