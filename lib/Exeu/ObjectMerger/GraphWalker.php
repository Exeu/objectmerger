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

namespace Exeu\ObjectMerger;

use Metadata\MetadataFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Exeu\ObjectMerger\Metadata\PropertyMetadata;

/**
 * The GraphWalker walks through every property of the object
 * and calls on each comparable property the visitor.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class GraphWalker
{
    /**
     * @var array
     */
    protected $visitedObjects = array();

    /**
     * @var MetadataFactory
     */
    protected $metadataFactory;

    /**
     * @var MergingVisitor
     */
    protected $visitor;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructor.
     *
     * @param MetadataFactory          $metadataFactory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(MetadataFactory $metadataFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->metadataFactory = $metadataFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->visitor         = new MergingVisitor();
    }

    /**
     * Accepts an objectpair and going through its properties for calling the visitor on each
     * comparable property.
     *
     * @param object $mergeFrom Sourceobject
     * @param object $mergeTo   Targetobject
     */
    public function accept($mergeFrom, $mergeTo)
    {
        // No object is passed either for mergeFrom or mergeTo.
        if (!is_object($mergeFrom) || !is_object($mergeTo)) {
            return;
        }

        $class = get_class($mergeFrom);
        if (!$mergeTo instanceof $class) {
            return;
        }

        // If the object is not visited.
        if (isset($this->visitedObjects[spl_object_hash($mergeFrom)])) {
            return;
        }

        $classMetadata = $this->metadataFactory->getMetadataForClass(get_class($mergeFrom));

        // Preventing the object to be visited again.
        $this->visitedObjects[spl_object_hash($mergeFrom)] = true;

        // Preparing a new ExecutionContext.
        $executionContext = new MergeContext($classMetadata, $this, $mergeFrom, $mergeTo);

        foreach ($classMetadata->propertyMetadata as $comparableProperty) {
            /** @var PropertyMetadata $comparableProperty */
            switch ($comparableProperty->type) {
                case 'string':
                    $this->visitor->mergeString($comparableProperty, $executionContext);
                    break;
                case 'object':
                    $this->visitor->mergeObject($comparableProperty, $executionContext);
                    break;
                case 'boolean':
                    $this->visitor->mergeBoolean($comparableProperty, $executionContext);
                    break;
                case 'Collection':
                    $this->visitor->mergeCollection($comparableProperty, $executionContext);
                    break;
            }
        }
    }

    /**
     * Gets the mergevisitor.
     *
     * @return MergingVisitor
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * Gets MetadataFactory
     *
     * @return MetadataFactory
     */
    public function getMetadataFactory()
    {
        return $this->metadataFactory;
    }
}
