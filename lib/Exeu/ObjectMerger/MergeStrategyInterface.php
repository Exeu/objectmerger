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
 * This interface describes a single MergeStrategy.
 * Mergestrategies are applied when a collection of objects is going to be merged.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
interface MergeStrategyInterface
{
    /**
     * Applies a the mergestrategy on a passed value.
     *
     * @param PropertyMetadata $propertyMetadata
     * @param array            $collectedValues
     * @param MergeContext     $context
     */
    public function apply(PropertyMetadata $propertyMetadata, array $collectedValues, MergeContext $context);
}
