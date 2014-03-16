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

namespace Exeu\ObjectMerger\Accessor;

/**
 * Base implementation of AccessorInterface using the relfection api.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ReflectionAccessor implements AccessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function getValue(\ReflectionProperty $property, $object)
    {
        return $property->getValue($object);
    }

    /**
     * {@inheritDoc}
     */
    public function setValue(\ReflectionProperty $property, $object, $value)
    {
        $property->setValue($object, $value);
    }
}
