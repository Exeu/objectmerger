<?php

namespace Exeu\ObjectComparer\Metadata\Driver;

use Doctrine\Common\Annotations\AnnotationReader;
use Exeu\ObjectComparer\Annotation\Comparable;
use Metadata\ClassMetadata;
use Metadata\Driver\DriverInterface;
use Exeu\ObjectComparer\Metadata\PropertyMetadata;

/**
 * Created by PhpStorm.
 * User: jan
 * Date: 25.02.14
 * Time: 21:17
 */

class AnnotationDriver implements DriverInterface
{
    /**
     * @var \Doctrine\Common\Annotations\AnnotationReader
     */
    private $reader;

    public function __construct(AnnotationReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param \ReflectionClass $class
     *
     * @return \Metadata\ClassMetadata
     */
    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $metadata = new ClassMetadata($class->getName());
        $metadata->fileResources[] = $class->getFileName();

        $propertiesMetadata = array();
        $propertiesAnnotations = array();

        foreach ($class->getProperties() as $property) {
            $propertiesMetadata[] = new PropertyMetadata($class->getName(), $property->getName());
            $propertiesAnnotations[] = $this->reader->getPropertyAnnotations($property);
        }

        foreach ($propertiesMetadata as $key => $propertyMetadata) {
            foreach ($propertiesAnnotations[$key] as $propertyAnnotation) {
                if ($propertyAnnotation instanceof Comparable) {
                    $propertyMetadata->type = $propertyAnnotation->type;
                    $propertyMetadata->objectIdentifier = $propertyAnnotation->objectIdentifier;
                }
            }

            $metadata->addPropertyMetadata($propertyMetadata);
        }

        return $metadata;
    }
}