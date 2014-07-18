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

use Exeu\ObjectMerger\Accessor\PublicMethodAccessor;
use Exeu\ObjectMerger\Accessor\ReflectionAccessor;
use Exeu\ObjectMerger\EventDispatcher\EventDispatcherInterface;
use Exeu\ObjectMerger\MergeHandler\CollectionHandler;
use Metadata\MetadataFactory;

/**
 * The ObjectMerger merges to objects of any complexity.
 *
 * Therefor it creates a GraphWalker which goes through any property of a class
 * and delegating the merging process to a MergingVisitor.
 *
 * Which properties are mergeable is defined whith the Mergeable metadata.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ObjectMerger
{
    const VERSION = '1.0.0-DEV';

    /**
     * @var GraphWalker
     */
    protected $graphWalker;

    /**
     * Constructor.
     *
     * @param MetadataFactory                   $metadataFactory
     * @param PropertyAccessorRegistryInterface $propertyAccessorRegistry
     * @param MergeHandlerRegistryInterface     $mergeHandlerRegistry
     * @param EventDispatcherInterface          $dispatcher
     */
    public function __construct(
        MetadataFactory $metadataFactory,
        PropertyAccessorRegistryInterface $propertyAccessorRegistry,
        MergeHandlerRegistryInterface $mergeHandlerRegistry,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->addDefaultPropertyAccessors($propertyAccessorRegistry);
        $this->addDefaultMergeHandler($mergeHandlerRegistry);

        $this->graphWalker = new GraphWalker(
            $metadataFactory,
            $propertyAccessorRegistry,
            $mergeHandlerRegistry,
            $dispatcher
        );
    }

    protected function addDefaultMergeHandler(MergeHandlerRegistryInterface $mergeHandlerRegistry)
    {
        $mergeHandlerRegistry
            ->addMergeHandler(new CollectionHandler());
    }

    /**
     * Adds the default PropertyAccessors to the registry.
     *
     * @param PropertyAccessorRegistryInterface $propertyAccessorRegistry
     */
    protected function addDefaultPropertyAccessors(PropertyAccessorRegistryInterface $propertyAccessorRegistry)
    {
        $propertyAccessorRegistry
            ->addPropertyAccessor(new ReflectionAccessor())
            ->addPropertyAccessor(new PublicMethodAccessor());
    }

    /**
     * Merges to objects together.
     *
     * @param object $mergeFrom Sourceobject
     * @param object $mergeTo   Targetobject
     */
    public function merge($mergeFrom, $mergeTo)
    {
        $this->graphWalker->accept($mergeFrom, $mergeTo);
    }

    public function flushStack()
    {
        $this->graphWalker->flushStack();
    }
}
