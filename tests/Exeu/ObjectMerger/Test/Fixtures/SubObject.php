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

namespace Exeu\ObjectMerger\Test\Fixtures;

use Exeu\ObjectMerger\Annotation\Mergeable;
use Exeu\ObjectMerger\Annotation\ObjectIdentifier;

/**
 * Class Test
 *
 * @Mergeable(accessor="public_method")
 * @ObjectIdentifier({"fullname"})
 */
class SubObject
{
    /**
     * @Mergeable(type="string")
     */
    private $fullname;

    /**
     * @Mergeable(type="boolean")
     */
    private $ignored;

    /**
     * @Mergeable(type="object")
     */
    private $testA;

    private $notMergeable;

    private $noGetterAndSetter;

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setIgnored($ignored)
    {
        $this->ignored = $ignored;
    }

    public function getIgnored()
    {
        return $this->ignored;
    }

    public function setTestA($testA)
    {
        $this->testA = $testA;
    }

    public function setNotMergeable($notMergeable)
    {
        $this->notMergeable = $notMergeable;
    }

    public function getNotMergeable()
    {
        return $this->notMergeable;
    }
} 