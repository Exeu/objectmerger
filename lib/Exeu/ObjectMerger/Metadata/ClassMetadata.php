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

use Exeu\ObjectMerger\Annotation\Mergeable;
use Exeu\ObjectMerger\Exception\MetadataParseException;
use Metadata\MergeableClassMetadata;
use Metadata\MergeableInterface;

/**
 * Metadata for a single class.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ClassMetadata extends MergeableClassMetadata
{
    /**
     * @var string
     */
    public $accessor = Mergeable::ACCESSOR_REFLECTION;

    /**
     * @var array
     */
    public $objectIdentifier = null;

    /**
     * Serializes the current ClassMetadata.
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->accessor,
            $this->objectIdentifier,
            parent::serialize()
        ));
    }

    /**
     * Deserializes the current ClassMetadata.
     *
     * @param string $str
     */
    public function unserialize($str)
    {
        list(
            $this->accessor,
            $this->objectIdentifier,
            $parentStr
            ) = unserialize($str);

        parent::unserialize($parentStr);
    }

    /**
     * {@inheritDoc}
     */
    public function merge(MergeableInterface $object)
    {
        if (!$object instanceof ClassMetadata) {
            throw new MetadataParseException();
        }

        parent::merge($object);

        if ($object->objectIdentifier !== null) {
            $this->objectIdentifier = $object->objectIdentifier;
        }
    }
}
