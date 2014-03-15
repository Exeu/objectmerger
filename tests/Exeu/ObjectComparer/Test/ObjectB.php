<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 22.02.14
 * Time: 16:06
 */

namespace Exeu\ObjectComparer\Test;


class ObjectB
{
    private $id;

    /**
     * @var
     *
     * @Comparable(type="string")
     */
    private $fullname;

    /**
     * @var
     *
     * @Comparable(type="string")
     */
    private $ignored;

    /**
     * @param mixed $ignored
     */
    public function setIgnored($ignored)
    {
        $this->ignored = $ignored;
    }

    /**
     * @return mixed
     */
    public function getIgnored()
    {
        return $this->ignored;
    }

    /**
     * @param mixed $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
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
} 