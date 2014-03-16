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

/**
 * Class GraphWalker
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
     * Constructor.
     *
     * @param MetadataFactory $metadataFactory
     */
    public function __construct(MetadataFactory $metadataFactory)
    {
        $this->metadataFactory = $metadataFactory;
        $this->visitor = new MergingVisitor();
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
        if (get_class($mergeFrom) !== get_class($mergeTo)) {
            return;
        }

        $objectMetadata = $this->metadataFactory->getMetadataForClass(get_class($mergeFrom));
        $classMetadata  = $objectMetadata->getRootClassMetadata();

        if (isset($this->visitedObjects[spl_object_hash($mergeFrom)])) {
            return;
        }

        $this->visitedObjects[spl_object_hash($mergeFrom)] = true;

        // Preparing a new ExecutionContext
        $executionContext = new MergeContext($classMetadata, $this, $mergeFrom, $mergeTo);

        foreach ($classMetadata->propertyMetadata as $comparableProperty) {
            /** @var PropertyMetadata $comparableProperty */
            switch ($comparableProperty->type) {
                case 'string':
                    $this->visitor->mergeString($comparableProperty->reflection, $executionContext);
                    break;
                case 'object':
                    $this->visitor->mergeObject($comparableProperty->reflection, $executionContext);
                    break;
                case 'boolean':
                    $this->visitor->mergeBoolean($comparableProperty->reflection, $executionContext);
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
}
