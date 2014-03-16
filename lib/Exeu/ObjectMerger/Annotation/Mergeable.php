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

namespace Exeu\ObjectMerger\Annotation;

/**
 * Mergeable annotaion.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 *
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
class Mergeable
{
    /**
     * Constant for the propertyaccessor "reflection".
     */
    const ACCESSOR_REFLECTION    = 'reflection';

    /**
     * Constant for the propertyaccessor "public_method".
     */
    const ACCESSOR_PUBLIC_METHOD = 'public_method';

    /**
     * Constant for the "addMissing" mergingstrategy.
     */
    const MERGE_STRATEGY_ADD_MISSING = 'addMissing';

    /**
     * Constant for the emtpyvaluestrategy "ignore"
     */
    const EMPTY_VALUE_STRATEGY_IGNORE = 'ignore';

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $objectIdentifier = null;

    /**
     * @var string
     */
    public $collectionMergeStrategy = null;

    /**
     * @var string
     */
    public $accessor = Mergeable::ACCESSOR_REFLECTION;

    /**
     * @var string
     */
    public $emptyValueStrategy = Mergeable::EMPTY_VALUE_STRATEGY_IGNORE;
}
