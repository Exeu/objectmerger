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

namespace Exeu\ObjectMerger\MergeHandler;

use Exeu\ObjectMerger\MergeHandlerInterface;
use Exeu\ObjectMerger\MergeHandlerRegistryInterface;

/**
 * A simple registry to register custom mergehandler.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class MergeHandlerRegistry implements MergeHandlerRegistryInterface
{
    /**
     * @var array
     */
    protected $mergeHandler = array();

    /**
     * {@inheritDoc}
     */
    public function addMergeHandler(MergeHandlerInterface $mergeHandler)
    {
        if (!array_key_exists($mergeHandler->getType(), $this->mergeHandler)) {
            $this->mergeHandler[$mergeHandler->getType()] = $mergeHandler;
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMergeHandler($type)
    {
        return array_key_exists($type, $this->mergeHandler) ? $this->mergeHandler[$type] : null;
    }
}