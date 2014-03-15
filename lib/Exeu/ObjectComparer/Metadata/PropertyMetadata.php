<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 28.02.14
 * Time: 20:53
 */

namespace Exeu\ObjectComparer\Metadata;

use Metadata\PropertyMetadata as BasePropertyMetadata;

class PropertyMetadata extends BasePropertyMetadata
{
    public $type;

    public $objectIdentifier;

    public function serialize()
    {
        return serialize(array(
            $this->type,
            $this->objectIdentifier,
            parent::serialize()
        ));
    }

    public function unserialize($str)
    {
        list(
            $this->type,
            $this->objectIdentifier,
            $parentStr
            ) = unserialize($str);

        parent::unserialize($parentStr);
    }
} 