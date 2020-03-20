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
        $arrayHelper = new Arr();

        $this->assertIsBool($arrayHelper->isEmpty($arrayToTest));
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
        $arrayHelper = new Arr();

        $this->assertIsBool($arrayHelper->isAssoc($arrayToTest));
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
        $arrayHelper = new Arr();

        if (! $arrayHelper->isEmpty($arrayToTest)) {
            // first value
            $this->assertSame($arrayHelper->first($arrayToTest), reset($arrayToTest));
            // first key
            $this->assertSame($arrayHelper->first($arrayToTest, true), array_key_first($arrayToTest));
        } else {
            $this->assertNull($arrayHelper->first($arrayToTest));
            $this->assertNull($arrayHelper->first($arrayToTest));
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
        $arrayHelper = new Arr();

        if (! $arrayHelper->isEmpty($arrayToTest)) {
            // first value
            $this->assertSame($arrayHelper->last($arrayToTest), end($arrayToTest));
            // first key
            $this->assertSame($arrayHelper->last($arrayToTest, true), array_key_last($arrayToTest));
        } else {
            $this->assertNull($arrayHelper->last($arrayToTest));
            $this->assertNull($arrayHelper->last($arrayToTest));
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
        $arrayHelper = new Arr();

        $this->assertTrue($arrayHelper->sort($arrayToTest));
        $this->assertTrue($arrayHelper->sort($arrayToTest, true));
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
        $arrayHelper = new Arr();

        $valueToAdd =  'Value to Add';
        $valueToAdd2 = 'Value to Add 2';

        $this->assertIsInt($arrayHelper->add($arrayToTest, $valueToAdd));
        $this->assertSame($arrayHelper->first($arrayToTest), $valueToAdd);

        $this->assertIsInt($arrayHelper->add($arrayToTest, $valueToAdd2, false));
        $this->assertSame($arrayHelper->last($arrayToTest), $valueToAdd2);
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
        $arrayHelper = new Arr();

        $valueToTest =  'Value to test';

        $this->assertIsBool($arrayHelper->exists($valueToTest, $arrayToTest));
        $this->assertIsBool($arrayHelper->exists($valueToTest, $arrayToTest, true));
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
        $arrayHelper = new Arr();

        $keyToTest  = 0;
        $keyToTest2 = 'KeyToTest';

        $this->assertIsBool($arrayHelper->keyExists($keyToTest, $arrayToTest));
        $this->assertIsBool($arrayHelper->keyExists($keyToTest, $arrayToTest, true));
        $this->assertIsBool($arrayHelper->keyExists($keyToTest2, $arrayToTest));
        $this->assertIsBool($arrayHelper->keyExists($keyToTest2, $arrayToTest, true));
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
        $arrayHelper = new Arr();

        $searchValues = 0;
        $this->assertIsArray($arrayHelper->keys($arrayToTest));
        $this->assertIsArray($arrayHelper->keys($arrayToTest, $searchValues));
        $this->assertIsArray($arrayHelper->keys($arrayToTest, $searchValues, true));
        $this->assertIsArray($arrayHelper->keys($arrayToTest, null, true));
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
        $arrayHelper = new Arr();

        $this->assertIsArray($arrayHelper->values($arrayToTest));
        $this->assertIsArray($arrayHelper->toNumIndexed($arrayToTest));
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
        $arrayHelper = new Arr();

        $flippedArray = $arrayHelper->flip($arrayToTest);
        $this->assertIsArray($flippedArray);
        $this->assertSame($arrayHelper->keys($arrayToTest), $arrayHelper->values($flippedArray));
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
        $arrayHelper = new Arr();

        $this->assertIsObject($arrayHelper->arrayToObject($arrayToTest));
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
        $arrayHelper = new Arr();

        $this->assertIsArray($arrayHelper->sortObjectsArrayByAttribute($arrayToTest, 'robert'));
        $this->assertIsArray($arrayHelper->sortObjectsArrayByAttribute($arrayToTest, 'robert', true));
        $this->assertIsArray($arrayHelper->sortObjectsArrayByAttribute($arrayToTest, 'simone'));
        $this->assertIsArray($arrayHelper->sortObjectsArrayByAttribute($arrayToTest, 'simone', true));
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
        $arrayHelper = new Arr();

        foreach ($arrayToTest as $object) {
            $this->assertIsArray($arrayHelper->objectToArray($object));
        }
    }
}