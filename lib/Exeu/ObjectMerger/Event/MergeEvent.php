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

namespace Exeu\ObjectMerger\Event;

use Exeu\ObjectMerger\MergeContext;

/**
 * A simple MergeEvent.
 * Within this event you have access to the merge context and to the type of merge (pre or post).
 * You can manipulate the mergecontext but you always should do this with caution.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class MergeEvent extends Event
{
    /**
     * The pre merge event type.
     */
    const TYPE_PRE  = 1;

    /**
     * The post merge event type.
     */
    const TYPE_POST = 2;

    /**
     * @var MergeContext
     */
    protected $mergeContext;

    /**
     * @var int
     */
    protected $type;

    /**
     * Constructor.
     *
     * @param              $type
     * @param MergeContext $context
     */
    public function __construct($type, MergeContext $context)
    {
        $this->type         = $type;
        $this->mergeContext = $context;
    }

    /**
     * Sets MergeContext.
     *
     * @param MergeContext $mergeContext
     */
    public function setMergeContext(MergeContext $mergeContext)
    {
        $this->mergeContext = $mergeContext;
    }

    /**
     * Gets MergeContext.
     *
     * @return MergeContext
     */
    public function getMergeContext()
    {
        return $this->mergeContext;
    }

    /**
     * Sets Type.
     *
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets Type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}
