<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 28.12.13
 * Time: 11:13
 */

namespace Exeu\ObjectComparer\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Exeu\ObjectComparer\ObjectComparer;

class TestTest extends \PHPUnit_Framework_TestCase
{

    public function testX()
    {
        $bla = new ObjectComparer();

        $objectA = new ObjectA();
        $objectB = new ObjectB();
        $objectC = new ObjectB();

        $objectA->setId(1);
        $objectA->setName('Jan');
        $objectA->setStreet('blubb');

        $objectB->setId(12);
        $objectB->setFullname('Jhon');
        $objectB->setIgnored(false);

        $objectC->setId(13);
        $objectC->setFullname('Jhan');
        $objectC->setIgnored(false);

        $coll = new ArrayCollection();
        $coll->add($objectB);
        $coll->add($objectC);

        $objectA->setFriends($coll);

        $objectAA = new ObjectA();
        $objectBB = new ObjectB();
        $objectCC = new ObjectB();

        $objectAA->setId(1);
        $objectAA->setName('Jan22');
        $objectAA->setStreet('blabb');

        $objectBB->setId(12);
        $objectBB->setFullname('Jhon2');
        $objectBB->setIgnored(true);

        $objectCC->setId(13);
        $objectCC->setFullname('Jhan');
        $objectCC->setIgnored(false);

        $coll2 = new ArrayCollection();
        $coll2->add($objectBB);
        $coll2->add($objectCC);

        $objectAA->setFriends($coll2);


        $bla->compare($objectA, $objectAA);
    }
} 