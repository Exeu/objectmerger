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

use Exeu\ObjectMerger\Accessor\AccessorInterface;
use Exeu\ObjectMerger\Accessor\PublicMethodAccessor;
use Exeu\ObjectMerger\Accessor\ReflectionAccessor;
use Exeu\ObjectMerger\Metadata\ClassMetadata;


/**
 * Class MergeContext
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
        $this->metadata = $metadata;
        $this->graphWalker = $graphWalker;
        $this->mergeFrom = $mergeFrom;
        $this->mergeTo = $mergeTo;

        switch ($this->metadata->accessor) {
            case 'public_method':
                $this->propertyAccessor = new PublicMethodAccessor();
                break;
            case 'reflection':
            default:
                $this->propertyAccessor = new ReflectionAccessor();
                break;
        }
    }

    /**
     * @param GraphWalker $graphWalker
     */
    public function setGraphWalker($graphWalker)
    {
        $this->graphWalker = $graphWalker;
    }

    /**
     * @return GraphWalker
     */
    public function getGraphWalker()
    {
        return $this->graphWalker;
    }

    /**
     * @param object $mergeFrom
     */
    public function setMergeFrom($mergeFrom)
    {
        $this->mergeFrom = $mergeFrom;
    }

    /**
     * @return object
     */
    public function getMergeFrom()
    {
        return $this->mergeFrom;
    }

    /**
     * @param object $mergeTo
     */
    public function setMergeTo($mergeTo)
    {
        $this->mergeTo = $mergeTo;
    }

    /**
     * @return object
     */
    public function getMergeTo()
    {
        return $this->mergeTo;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return ClassMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param AccessorInterface $propertyAccessor
     */
    public function setPropertyAccessor($propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * @return AccessorInterface
     */
    public function getPropertyAccessor()
    {
        return $this->propertyAccessor;
    }
}
