<?php

namespace RedlabTeam\Helper\Test;

use \PHPUnit\Framework\TestCase,
    RedlabTeam\Helper\Json;
use RedlabTeam\Helper\Str;

/**
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class StrTest extends TestCase
{
    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getNonStringData()
    {
        return [
            [['Robert', 'Simone', 'Huguette']],
            [function(){ return true; }],
            [90],
            [new \DateTime('now')],
            [null]
        ];
    }

    /**
     * @return array
     */
    public function getStringData()
    {
        return [
            ['["0001800122", "0001017041", "0001800129", "0001800165", "0001800118", "0001005002", "0001208157"]'],
            ['12345'],
            ['It\'s a trap'],
            ['{"salesOrderNumber":"0025140723","purchaseOrderNumber":"4501371526","purchaseOrderDate":"2018-04-23","documentDate":"2018-04-23"}'],
            ['true'],
            ['false'],
            ['1'],
            ['0']
        ];
    }

    /**
     * @dataProvider getNonStringData
     * @dataProvider getStringData
     *
     * @param $dataToTest
     */
    public function testIsAlphaNumeric($dataToTest)
    {
        $stringHelper = new Str();

        $this->assertIsBool($stringHelper->isAlphaNumeric($dataToTest));
    }

    /**
     * @dataProvider getStringData
     *
     * @param $dataToTest
     */
    public function testIsBool($dataToTest)
    {
        $stringHelper = new Str();

        $this->assertIsBool($stringHelper->isBool($dataToTest));
    }
}