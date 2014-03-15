<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 25.02.14
 * Time: 21:08
 */

namespace Exeu\ObjectComparer\Visitor;


use Doctrine\Common\Annotations\AnnotationReader;
use Exeu\ObjectComparer\Metadata\Driver\AnnotationDriver;
use Metadata\MetadataFactory;

class ObjectVisitor
{
    private $metadataFactory;

    private $visited;

    public function __construct()
    {
        $reader = new AnnotationReader();
        $driver = new AnnotationDriver($reader);

        $metadataFactory = new MetadataFactory($driver);
        $metadataFactory->setIncludeInterfaces(true);;

        $this->metadataFactory = $metadataFactory;
        $this->visited = new \SplObjectStorage();
    }

    public function visit($object1, $object2)
    {
        if ($this->visited->contains($object1)) {
            return;
        }

        $metadata = $this->metadataFactory->getMetadataForClass(get_class($object1));
    }
} 