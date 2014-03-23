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

/**
 * @Mergeable
 */
class ObjectA
{
    private $id;

    /**
     * @Mergeable(type="string")
     */
    private $name;

    /**
     * @Mergeable(type="string")
     */
    private $street;

    /**
     * @Mergeable(type="boolean")
     */
    private $bool;

    /**
     * @Mergeable(type="object")
     */
    private $obj;

    /**
     * @Mergeable(type="Collection<Exeu\ObjectMerger\Test\Fixtures\ObjectB>", collectionMergeStrategy="addMissing")
     */
    private $friends;

    private $notMergeable;

    public function setBool($bool)
    {
        $this->bool = $bool;
    }

    public function getBool()
    {
        return $this->bool;
    }

    public function setFriends($friends)
    {
        $this->friends = $friends;
    }

    public function getFriends()
    {
        return $this->friends;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setObj($obj)
    {
        $obj->setTestA($this);

        $this->obj = $obj;
    }

    public function getObj()
    {
        return $this->obj;
    }
} 