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

namespace Exeu\ObjectMerger\Metadata;

use Metadata\PropertyMetadata as BasePropertyMetadata;

/**
 * Metadata for a single property.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class PropertyMetadata extends BasePropertyMetadata
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $objectIdentifier;

    /**
     * @var string
     */
    public $collectionMergeStrategy;

    /**
     * @var string
     */
    public $emptyValueStrategy = 'ignore';

    /**
     * Serializes the current propertymetadata.
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->type,
            $this->objectIdentifier,
            $this->collectionMergeStrategy,
            $this->emptyValueStrategy,
            parent::serialize()
        ));
    }

    /**
     * Deserializes the current propertymetadata.
     *
     * @param string $str
     */
    public function unserialize($str)
    {
        list(
            $this->type,
            $this->objectIdentifier,
            $this->collectionMergeStrategy,
            $this->emptyValueStrategy,
            $parentStr
            ) = unserialize($str);

        parent::unserialize($parentStr);
    }
}
