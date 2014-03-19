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
 * ClassDetermineStrategy annotaion.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 *
 * @Annotation
 * @Target({"CLASS"})
 */
class ClassDetermineStrategy
{
    /**
     * Constant for the get_class comparator.
     */
    const STRATEGY_GET_CLASS = 'get_class';

    /**
     * Constant for the instance_of comparator.
     */
    const STRATEGY_INSTANCE_OF = 'instance_of';

    /**
     * @var string
     */
    public $type;
}
