<?php

namespace Redlab\Helper\Test;

use \PHPUnit\Framework\TestCase,
    Redlab\Helper\Json;

/**
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class JsonTest extends TestCase
{
    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getDataToEncode()
    {
        return [
            [['Robert', 'Simone', 'Huguette']],
            ['It\'s a trap'],
            [90],
            [new \DateTime('now')],
            [null]
        ];
    }

    /**
     * @dataProvider getDataToEncode
     *
     * @param $dataToEncode
     */
    public function testEncode($dataToEncode)
    {
        $jsonHelper = new Json();

        $jsonHelper->encode($dataToEncode);

        $this->assertSame(0, $jsonHelper->getLastErrorCode());
    }

    /**
     * @return array
     */
    public function getJsonToDecode()
    {
        return [
            ['["0001800122", "0001017041", "0001800129", "0001800165", "0001800118", "0001005002", "0001208157"]'],
            ['12345'],
            ['It\'s a trap'],
            ['{"salesOrderNumber":"0025140723","purchaseOrderNumber":"4501371526","purchaseOrderDate":"2018-04-23","documentDate":"2018-04-23"}']
        ];
    }

    /**
     * @dataProvider getJsonToDecode
     *
     * @param $jsonToDecode
     */
    public function testDecode($jsonToDecode)
    {
        $jsonHelper = new Json();

        $jsonHelper->decode($jsonToDecode);

        $this->assertSame(0, $jsonHelper->getLastErrorCode());
    }
}