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
 * Interface MergeHandlerInterface.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
interface MergeHandlerInterface
{
    /**
     * Performs a custom merge operation.
     * Within the context you have access to the objectpair and the graphwalker.
     *
     * @param PropertyMetadata $propertyMetadata
     * @param MergeContext     $context
     */
    public function merge(PropertyMetadata $propertyMetadata, MergeContext $context);

    /**
     * Returns the type for which the handler should take the merge operation.
     *
     * <pre>
     *   // @Mergeable(type="MyCustomObject")
     *   $propertyName = 'foo';
     * </pre>
     *
     * @return string
     */
    public function getType();
}
