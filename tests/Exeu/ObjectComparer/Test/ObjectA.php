<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 22.02.14
 * Time: 16:06
 */

namespace Exeu\ObjectComparer\Test;


use Exeu\ObjectComparer\Annotation\Comparable;

class ObjectA
{
    private $id;

    /**
     * @var
     *
     * @Comparable(type="string")
     */
    private $name;

    /**
     * @var
     *
     * @Comparable(type="string")
     */
    private $street;

    /**
     * @var
     *
     * @Comparable(type="Collection", objectIdentifier="id")
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
} 