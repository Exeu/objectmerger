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

use Exeu\ObjectMerger\Exception\MergeException;
use Exeu\ObjectMerger\Metadata\PropertyMetadata;

/**
 * The MergingVisitor is responsible for the merging process.
 *
 * It can handle simple variabletypes and collections of objects.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class MergingVisitor
{
    /**
     * Tries to merge two objects by self registered merging handler.
     *
     * @param PropertyMetadata $property
     * @param MergeContext     $context
     *
     * @throws MergeException
     */
    public function mergeByHandler(PropertyMetadata $property, MergeContext $context)
    {
        $mergeHandler = $context->getGraphWalker()->getMergeHandlerRegistry()->getMergeHandler($property->type);

        if (!$mergeHandler) {
            throw new MergeException(sprintf('No handler found for the type "%s"', $property->type));
        }

        $mergeHandler->merge($property, $context);
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
     * Merges a property just by copying from left to right.
     *
     * @param PropertyMetadata $property Metadata of the property
     * @param MergeContext     $context  The current mergingcontext
     */
    public function mergeMixed(PropertyMetadata $property, MergeContext $context)
    {
        $reflectionProperty = $property->reflection;

        $context->getPropertyAccessor()->setValue(
            $reflectionProperty,
            $context->getMergeTo(),
            $context->getPropertyAccessor()->getValue($reflectionProperty, $context->getMergeFrom())
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
