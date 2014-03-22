#Objectmerger

With this library you have the abillity to merge two objects of the same type.

## Build status

[![Build Status](http://ci.pixel-web.org/job/objectmerger/badge/icon)](http://ci.pixel-web.org/job/objectmerger/)

## Installation

### Composer

Add the objectmerger in your existing composer.json or create a new composer.json:

```js
{
    "require": {
        "exeu/objectmerger": "dev-master"
    }
}
```

Now tell composer to download the library by running the command:

``` bash
$ php composer.phar install
```

Composer will generate the autoloader file automaticly. So you only have to include this.
Typically its located in the vendor dir and its called autoload.php

##Basic Usage:

```php
<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Exeu\ObjectMerger\Accessor\PropertyAccessorRegistry;
use Exeu\ObjectMerger\EventDispatcher\EventDispatcher;
use Exeu\ObjectMerger\MergeHandler\MergeHandlerRegistry;
use Exeu\ObjectMerger\Metadata\Driver\AnnotationDriver;
use Exeu\ObjectMerger\ObjectMerger;
use Metadata\MetadataFactory;

// ...

$reader  = new AnnotationReader();
$driver  = new AnnotationDriver($reader);

$metadataFactory            = new MetadataFactory($driver);
$eventDispatcher            = new EventDispatcher();
$propertyAccessorRegistry   = new PropertyAccessorRegistry();
$mergeHanlderRegistry       = new MergeHandlerRegistry();

$objectMerger = new ObjectMerger($metadataFactory, $propertyAccessorRegistry, $mergeHanlderRegistry, $eventDispatcher);

// ...

$objectA = new Foo();
$objectA->setBar('baz');

$objectB = new Foo();
$objectB->setBar('overwritten-baz');

$objectMerger->merge($objectA, $objectB);

echo $objectB->getBar(); // will return 'baz'
```
