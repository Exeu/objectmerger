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

namespace Exeu\ObjectMerger\MergeStrategy;

use Exeu\ObjectMerger\MergeContext;
use Exeu\ObjectMerger\MergeStrategyInterface;
use Exeu\ObjectMerger\Metadata\PropertyMetadata;

/**
 * The AddMissing strategy pushes objects which are not in the mergeto object collection into this collection.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class AddMissing implements MergeStrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function apply(PropertyMetadata $propertyMetadata, array $collectedValues, MergeContext $context)
    {
        $reflectionProperty        = $propertyMetadata->reflection;
        $mergeableObjectCollection = $context->getPropertyAccessor()->getValue(
            $reflectionProperty,
            $context->getMergeTo()
        );

        foreach ($collectedValues['missing'] as $missingValue) {
            $mergeableObjectCollection[] = $missingValue;
        }

        $context->getPropertyAccessor()->setValue(
            $reflectionProperty,
            $context->getMergeTo(),
            $mergeableObjectCollection
        );
    }
}
