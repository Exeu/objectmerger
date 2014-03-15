<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 28.12.13
 * Time: 11:04
 */

namespace Exeu\ObjectComparer\Annotation;

/**
 * Class Comparable
 * @package Exeu\ObjectComparer\Annotation
 *
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
class Comparable
{
    public $type;

    public $objectIdentifier = null;
} 