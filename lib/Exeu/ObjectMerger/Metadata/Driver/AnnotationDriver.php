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

namespace Exeu\ObjectMerger\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use Exeu\ObjectMerger\Annotation\ClassDetermineStrategy;
use Exeu\ObjectMerger\Annotation\Mergeable;
use Exeu\ObjectMerger\Annotation\ObjectIdentifier;
use Exeu\ObjectMerger\Metadata\ClassMetadata;
use Metadata\Driver\DriverInterface;
use Exeu\ObjectMerger\Metadata\PropertyMetadata;

/**
 * An implementation of the DriverInterface.
 * This class creates Metadataobject by reading the class annotations.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class AnnotationDriver implements DriverInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * Constructor.
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritDoc}
     */
    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $metadata = new ClassMetadata($class->getName());
        $metadata->fileResources[] = $class->getFileName();

        $classAnnotations = $this->reader->getClassAnnotations($class);
        foreach ($classAnnotations as $classAnnotation) {
            if ($classAnnotation instanceof Mergeable) {
                $metadata->accessor = $classAnnotation->accessor;
            } elseif ($classAnnotation instanceof ObjectIdentifier) {
                $metadata->objectIdentifier = $classAnnotation->fields;
            }
        }

        $propertiesMetadata    = array();
        $propertiesAnnotations = array();

        foreach ($class->getProperties() as $property) {
            $propertiesMetadata[] = new PropertyMetadata($class->getName(), $property->getName());
            $propertiesAnnotations[] = $this->reader->getPropertyAnnotations($property);
        }

        foreach ($propertiesMetadata as $key => $propertyMetadata) {
            foreach ($propertiesAnnotations[$key] as $propertyAnnotation) {
                if ($propertyAnnotation instanceof Mergeable) {
                    $propertyMetadata->setType($propertyAnnotation->type);
                    $propertyMetadata->collectionMergeStrategy = $propertyAnnotation->collectionMergeStrategy;
                    $propertyMetadata->emptyValueStrategy = $propertyAnnotation->emptyValueStrategy;

                    $metadata->addPropertyMetadata($propertyMetadata);
                }
            }
        }

        return $metadata;
    }
}
