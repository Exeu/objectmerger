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

use Exeu\ObjectMerger\Metadata\ClassMetadata;

/**
 * This contextclass is instanciated for each object comparsion.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class MergeContext
{
    /**
     * @var ClassMetadata
     */
    private $metadata;

    /**
     * @var GraphWalker
     */
    private $graphWalker;

    /**
     * @var object
     */
    private $mergeFrom;

    /**
     * @var object
     */
    private $mergeTo;

    /**
     * @var AccessorInterface
     */
    private $propertyAccessor;

    /**
     * Constructor.
     *
     * @param ClassMetadata $metadata
     * @param GraphWalker   $graphWalker
     * @param object        $mergeFrom
     * @param object        $mergeTo
     */
    public function __construct(ClassMetadata $metadata, GraphWalker $graphWalker, $mergeFrom, $mergeTo)
    {
        $this->metadata         = $metadata;
        $this->graphWalker      = $graphWalker;
        $this->mergeFrom        = $mergeFrom;
        $this->mergeTo          = $mergeTo;
        $this->propertyAccessor = $graphWalker
            ->getPropertyAccessorRegistry()
            ->getPropertyAccessor($this->metadata->accessor);
    }

    /**
     * @return GraphWalker
     */
    public function getGraphWalker()
    {
        return $this->graphWalker;
    }

    /**
     * @return object
     */
    public function getMergeFrom()
    {
        return $this->mergeFrom;
    }

    /**
     * @return object
     */
    public function getMergeTo()
    {
        return $this->mergeTo;
    }

    /**
     * @return ClassMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return AccessorInterface
     */
    public function getPropertyAccessor()
    {
        return $this->propertyAccessor;
    }
}
