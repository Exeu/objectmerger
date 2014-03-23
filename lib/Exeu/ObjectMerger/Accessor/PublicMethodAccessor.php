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

use Exeu\ObjectMerger\AccessorInterface;
use Exeu\ObjectMerger\Annotation\Mergeable;

/**
 * Base implementation of AccessorInterface using public methods (getter, setter) via reflection.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class PublicMethodAccessor implements AccessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function getValue(\ReflectionProperty $property, $object)
    {
        $propertyName   = $property->getName();
        $declaringClass = $property->getDeclaringClass();
        $getterName     = sprintf('get%s', ucfirst($propertyName));

        if (!$declaringClass->hasMethod($getterName)) {
            throw new \RuntimeException('No getter found for "' . $propertyName . '"');
        }

        return $declaringClass->getMethod($getterName)->invoke($object);
    }

    /**
     * {@inheritDoc}
     */
    public function setValue(\ReflectionProperty $property, $object, $value)
    {
        $propertyName   = $property->getName();
        $declaringClass = $property->getDeclaringClass();
        $setterName     = sprintf('set%s', ucfirst($propertyName));

        if (!$declaringClass->hasMethod($setterName)) {
            throw new \RuntimeException('No setter found for "' . $propertyName . '"');
        }

        $declaringClass->getMethod($setterName)->invoke($object, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return Mergeable::ACCESSOR_PUBLIC_METHOD;
    }
}
