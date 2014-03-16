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
 * Interface AccessorInterface.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
interface AccessorInterface
{
    /**
     * Gets a value from a property within the passed object.
     *
     * @param \ReflectionProperty $property The property
     * @param object              $object   The object
     *
     * @return mixed
     */
    public function getValue(\ReflectionProperty $property, $object);

    /**
     * Sets a value on a property within the passed object.
     *
     * @param \ReflectionProperty $property The property
     * @param object              $object   The object
     * @param mixed               $value    The value to be setted
     */
    public function setValue(\ReflectionProperty $property, $object, $value);
}
