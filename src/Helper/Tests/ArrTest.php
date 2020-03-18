<?php

namespace RedlabTeam\Helper\Test;

use \PHPUnit\Framework\TestCase,
    \StdClass,
    RedlabTeam\Helper\Arr;

/**
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class ArrTest extends TestCase
{
    /**
     * @return array
     */
    public function getAssocArraysToTest()
    {
        return [
            [['father' => 'Robert', 'mother' => 'Simone', 'fother' => 'Huguette']],
            [[]]
        ];
    }

    /**
     * @return array
     */
    public function getNumericallyIndexedArraysToTest()
    {
        return [
            [['Robert', 'Simone', 'Huguette']],
            [[1, 2, 3, 4, 5]],
            [['It\'s a trap', ['yes', 'no', 'maybe']]],
            [[]]
        ];
    }

    /**
     * @return array
     */
    public function getObjectsArraysToTest()
    {
        $object1 = new StdClass();
        $object1->robert = 2;
        $object1->simone = 5;
        $object2 = clone $object1;
        $object2->robert = 1;

        return [
            [[$object1, $object2]]
        ];
    }

    /**
     * Test if the array is empty array or not.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testIsEmpty(array $arrayToTest)
    {
        $this->assertIsBool(Arr::isEmpty($arrayToTest));
    }

    /**
     * Test if the array is an associative array or not.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testIsAssoc(array $arrayToTest)
    {
        $this->assertIsBool(Arr::isAssoc($arrayToTest));
    }

    /**
     * Test if the first value and the first key of the array are returned.
     * If the array is empty then it should return null.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testFirst(array $arrayToTest)
    {
        if (! Arr::isEmpty($arrayToTest)) {
            // first value
            $this->assertSame(Arr::first($arrayToTest), reset($arrayToTest));
            // first key
            $this->assertSame(Arr::first($arrayToTest, true), array_key_first($arrayToTest));
        } else {
            $this->assertNull(Arr::first($arrayToTest));
            $this->assertNull(Arr::first($arrayToTest));
        }
    }

    /**
     * Test if the last value and the last key of the array are returned.
     * If the array is empty then it should return null.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testLast(array $arrayToTest)
    {
        if (! Arr::isEmpty($arrayToTest)) {
            // first value
            $this->assertSame(Arr::last($arrayToTest), end($arrayToTest));
            // first key
            $this->assertSame(Arr::last($arrayToTest, true), array_key_last($arrayToTest));
        } else {
            $this->assertNull(Arr::last($arrayToTest));
            $this->assertNull(Arr::last($arrayToTest));
        }
    }

    /**
     * Test if the array is sorted.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testSort(array $arrayToTest)
    {
        $this->assertTrue(Arr::sort($arrayToTest));
        $this->assertTrue(Arr::sort($arrayToTest, true));
    }

    /**
     * Test if the value is added at the beginning or at the end of the array.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testAdd(array $arrayToTest)
    {
        $valueToAdd =  'Value to Add';
        $valueToAdd2 = 'Value to Add 2';

        $this->assertIsInt(Arr::add($arrayToTest, $valueToAdd));
        $this->assertSame(Arr::first($arrayToTest), $valueToAdd);

        $this->assertIsInt(Arr::add($arrayToTest, $valueToAdd2, false));
        $this->assertSame(Arr::last($arrayToTest), $valueToAdd2);
    }

    /**
     * Test if the value exists into the array.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testExists(array $arrayToTest)
    {
        $valueToTest =  'Value to test';

        $this->assertIsBool(Arr::exists($valueToTest, $arrayToTest));
        $this->assertIsBool(Arr::exists($valueToTest, $arrayToTest, true));
    }

    /**
     * Test if the key exists into the array.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testKeyExists(array $arrayToTest)
    {
        $keyToTest  = 0;
        $keyToTest2 = 'KeyToTest';

        $this->assertIsBool(Arr::keyExists($keyToTest, $arrayToTest));
        $this->assertIsBool(Arr::keyExists($keyToTest, $arrayToTest, true));
        $this->assertIsBool(Arr::keyExists($keyToTest2, $arrayToTest));
        $this->assertIsBool(Arr::keyExists($keyToTest2, $arrayToTest, true));
    }

    /**
     * Return the keys of the $arrayToTest as an indexed array.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testGetKeys(array $arrayToTest)
    {
        $searchValues = 0;
        $this->assertIsArray(Arr::keys($arrayToTest));
        $this->assertIsArray(Arr::keys($arrayToTest, $searchValues));
        $this->assertIsArray(Arr::keys($arrayToTest, $searchValues, true));
        $this->assertIsArray(Arr::keys($arrayToTest, null, true));
    }

    /**
     * Return the values of the $arrayToTest as an indexed array.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testGetValues(array $arrayToTest)
    {
        $this->assertIsArray(Arr::values($arrayToTest));
        $this->assertIsArray(Arr::toNumIndexed($arrayToTest));
    }

    /**
     * Test if the array is flip.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testFlip(array $arrayToTest)
    {
        $flippedArray = Arr::flip($arrayToTest);
        $this->assertIsArray($flippedArray);
        $this->assertSame(Arr::keys($arrayToTest), Arr::values($flippedArray));
    }

    /**
     * Test if the array is flip.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testToObject(array $arrayToTest)
    {
        $this->assertIsObject(Arr::arrayToObject($arrayToTest));
    }

    /**
     * Test if the array of objects can be sorted.
     *
     * @dataProvider getAssocArraysToTest
     * @dataProvider getNumericallyIndexedArraysToTest
     * @dataProvider getObjectsArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testObjectArrays(array $arrayToTest)
    {
        $this->assertIsArray(Arr::sortObjectsArrayByAttribute($arrayToTest, 'robert'));
        $this->assertIsArray(Arr::sortObjectsArrayByAttribute($arrayToTest, 'robert', true));
        $this->assertIsArray(Arr::sortObjectsArrayByAttribute($arrayToTest, 'simone'));
        $this->assertIsArray(Arr::sortObjectsArrayByAttribute($arrayToTest, 'simone', true));
    }

    /**
     * Test if the objects can be convert to array.
     *
     * @dataProvider getObjectsArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testObjectToArray(array $arrayToTest)
    {
        foreach ($arrayToTest as $object) {
            $this->assertIsArray(Arr::objectToArray($object));
        }
    }
}