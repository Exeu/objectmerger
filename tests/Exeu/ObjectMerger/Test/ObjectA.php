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

namespace Exeu\ObjectMerger\Test;

use Exeu\ObjectMerger\Annotation\Mergeable;

/**
 * @Mergeable
 */
class ObjectA
{
    private $id;

    /**
     * @var
     *
     * @Mergeable(type="string")
     */
    private $name;

    /**
     * @var
     *
     * @Mergeable(type="string")
     */
    private $street;

    /**
     * @var
     *
     * @Mergeable(type="object")
     */
    private $obj;

    /**
     * @var
     *
     * @Mergeable(type="Collection", objectIdentifier="id", collectionMergeStrategy="addMissing")
     */
    private $friends;

    /**
     * @param mixed $friends
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;
    }

    /**
     * @return mixed
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $obj
     */
    public function setObj($obj)
    {
        $obj->setTestA($this);

        $this->obj = $obj;
    }

    /**
     * @return mixed
     */
    public function getObj()
    {
        return $this->obj;
    }
} 