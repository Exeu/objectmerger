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

use Doctrine\Common\Annotations\AnnotationReader;
use Exeu\ObjectMerger\Metadata\Driver\AnnotationDriver;
use Metadata\MetadataFactory;

/**
 * Class ObjectMerger
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ObjectMerger
{
    const VERSION = '1.0.0-DEV';

    /**
     * Merges to objects together.
     *
     * @param object $mergeFrom Sourceobject
     * @param object $mergeTo   Targetobject
     */
    public function merge($mergeFrom, $mergeTo)
    {
        $graphWalker = $this->createMergingVisitor();
        $graphWalker->accept($mergeFrom, $mergeTo);
    }

    /**
     * Creates a new GraphWalker.
     *
     * @return GraphWalker
     */
    protected function createMergingVisitor()
    {
        $reader = new AnnotationReader();
        $metadataDriver  = new AnnotationDriver($reader);
        $metadataFactory = new MetadataFactory($metadataDriver);

        return new GraphWalker($metadataFactory);
    }
}
