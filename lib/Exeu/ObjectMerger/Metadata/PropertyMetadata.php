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

use Exeu\ObjectMerger\Exception\MetadataParseException;
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
    public $innerType;

    /**
     * @var string
     */
    public $collectionMergeStrategy;

    /**
     * @var string
     */
    public $emptyValueStrategy = 'ignore';

    /**
     * Sets the type and pareses some information about collections.
     *
     * @param $type
     *
     * @throws MetadataParseException
     */
    public function setType($type)
    {
        $matches = array();

        if (!preg_match('/^(.*?)(?:<([^>]*)>)?$/', $type, $matches)) {
            throw new MetadataParseException('Unable to parse type: ' . $type);
        }

        $this->type = $matches[1];

        if (count($matches) > 2) {
            $this->innerType = $matches[2];
        }
    }

    /**
     * Serializes the current propertymetadata.
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->type,
            $this->innerType,
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
            $this->innerType,
            $this->collectionMergeStrategy,
            $this->emptyValueStrategy,
            $parentStr
            ) = unserialize($str);

        parent::unserialize($parentStr);
    }
}
