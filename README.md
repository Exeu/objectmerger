#Objectmerger

With this library you have the abillity to merge two objects of the same type.

This library is under construction. Things will change.

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

###Adding mergeable metadata
Before you can merge objects you have to add some metadata about which property should be mergeable.
You can achieve this out of the box by three different ways: Annotations, YAML and XML.

####Annotation
```php
<?php
namespace Acme;

use Exeu\ObjectMerger\Annotation as Exeu;

class Foo
{
    /**
     * @Exeu\Mergeable(type="string")
     */
    private $bar;
    
    public function setBar($bar) { $this->bar = $bar; }
    public function getBar() { return $this->bar; }
}

```
####YAML
Not implemented yet. If you want to contribute -> Feel free and fork this library.

####XML
Not implemented yet. If you want to contribute -> Feel free and fork this library.

###Using the merger

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

$objectA = new \Acme\Foo();
$objectA->setBar('baz');

$objectB = new \Acme\Foo();
$objectB->setBar('overwritten-baz');

$objectMerger->merge($objectA, $objectB);

echo $objectB->getBar(); // will return 'baz'
```

##Registering CustomHandler:

A Customhandler is an own created merge handler. Creating a MergeHandler gives you the power of controlling HOW a property is beeing merged. Built in are some default mergehandler like (string, int, object, etc.).
Now we are at the point to create a new merge handler.
First of all you have to implement the MergeHandlerInterface.


```php
<?php

namespace Acme\Demo\Handler;

use Exeu\ObjectMerger\MergeHandlerInterface;
use Exeu\ObjectMerger\Metadata\PropertyMetadata;
use Exeu\ObjectMerger\MergeContext;

class CustomHandler implements MergeHandlerInterface
{
    public function merge(PropertyMetadata $propertyMetadata, MergeContext $context)
    {
       // DO YOUR AWESOME STUFF HERE
    }


    public function getType()
    {
        return 'MyCustomHandler';
    }
}
```

After youve Written your handler you can simply register it in the MergeHandlerRegistry:

```php
<?php
// bootrap as shown above.

$customMergeHandler   = new \Acme\Demo\Handler\CustomHandler();
$mergeHanlderRegistry = new MergeHandlerRegistry();
$mergeHandlerRegistry->addMergeHandler($customMergeHandler);


$objectMerger = new ObjectMerger($metadataFactory, $propertyAccessorRegistry, $mergeHanlderRegistry, $eventDispatcher);

// bootstrap as shown above.

```

After attaching the MergeHandler to the Registry it is ready to use.
Just add the MergeAnnotation to your property:

```php
<?php
namespace Acme;

use Exeu\ObjectMerger\Annotation as Exeu;

class Foo
{
    /**
     * @Exeu\Mergeable(type="MyCustomHandler")
     */
    private $bar;
    
    
    // ...
}

```




