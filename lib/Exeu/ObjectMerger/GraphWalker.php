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

use Exeu\ObjectMerger\Annotation\ClassDetermineStrategy;
use Exeu\ObjectMerger\ClassnameComparer\ClassInstance;
use Exeu\ObjectMerger\ClassnameComparer\GetClass;
use Exeu\ObjectMerger\ClassnameComparer\ReflectionParent;
use Exeu\ObjectMerger\Metadata\ClassMetadata;
use Metadata\MetadataFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
     * @var array
     */
    protected $classnameComparer = array();

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

        $this->classnameComparer[ClassDetermineStrategy::STRATEGY_GET_CLASS]   = new GetClass();
        $this->classnameComparer[ClassDetermineStrategy::STRATEGY_INSTANCE_OF] = new ClassInstance();
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
        // No object is passed either for mergeFrom or mergeTo
        if (!is_object($mergeFrom) || !is_object($mergeTo)) {
            return;
        }

        $classMetadata = $this->metadataFactory->getMetadataForClass(get_class($mergeTo));

        if (!$this->applyClassnameComparer($classMetadata, $mergeFrom, $mergeTo)) {
            return;
        }

        if (isset($this->visitedObjects[spl_object_hash($mergeFrom)])) {
            return;
        }

        // Preventing the object to be visited again.
        $this->visitedObjects[spl_object_hash($mergeFrom)] = true;

        // Preparing a new ExecutionContext
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
     * Applies a matching classnamecomparer.
     *
     * @param ClassMetadata $classMetadata
     * @param object        $mergeFrom
     * @param object        $mergeTo
     *
     * @return mixed
     * @throws \RuntimeException
     */
    protected function applyClassnameComparer(ClassMetadata $classMetadata, $mergeFrom, $mergeTo)
    {
        $strategy = $classMetadata->classDetermineStrategy;

        if (!array_key_exists($strategy, $this->classnameComparer)) {
            throw new \RuntimeException(sprintf(
                'The classDetermineStrategy "%s" does not exist!',
                $strategy
            ));
        }

        return $this->classnameComparer[$strategy]->equals($mergeFrom, $mergeTo);
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
}
