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
use Exeu\ObjectMerger\PropertyAccessorRegistryInterface;

/**
 * A simple registry to register propertyaccessors.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class PropertyAccessorRegistry implements PropertyAccessorRegistryInterface
{
    /**
     * @var array
     */
    protected $propertyAccessors = array();

    /**
     * {@inheritDoc}
     */
    public function addPropertyAccessor(AccessorInterface $propertyAccessor)
    {
        if (!array_key_exists($propertyAccessor->getName(), $this->propertyAccessors)) {
            $this->propertyAccessors[$propertyAccessor->getName()] = $propertyAccessor;
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAccessor($name)
    {
        if (!array_key_exists($name, $this->propertyAccessors)) {
            throw new \InvalidArgumentException(sprintf('No Propertyaccessor with the name "%s" found.', $name));
        }

        return $this->propertyAccessors[$name];
    }
}
