<?php

namespace Redlab\Helper\Test;

use \PHPUnit\Framework\TestCase,
    Redlab\Helper\Arr;

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
            [['father' => 'Robert', 'mother' => 'Simone', 'fother' => 'Huguette']]
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
            [['It\'s a trap', ['yes', 'no', 'maybe']]]
        ];
    }

    /**
     * @dataProvider getAssocArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testIsAssoc(array $arrayToTest)
    {
        $this->assertTrue(Arr::isAssoc($arrayToTest));
    }

    /**
     * @dataProvider getNumericallyIndexedArraysToTest
     *
     * @param array $arrayToTest
     */
    public function testIsNotAssoc(array $arrayToTest)
    {
        $this->assertFalse(Arr::isAssoc($arrayToTest));
    }
}