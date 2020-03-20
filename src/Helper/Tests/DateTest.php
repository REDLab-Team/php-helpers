<?php

namespace RedlabTeam\Helper\Test;

use \DateTime,
    \DateInterval,
    \PHPUnit\Framework\TestCase,
    RedlabTeam\Helper\Date;

/**
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class DateTest extends TestCase
{
    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getDatesToCompare()
    {
        $dateToCompare = new DateTime();
        $dateBefore = clone $dateToCompare;
        // 10 days before the date to compare
        $dateBefore->sub(new DateInterval('P10D'));
        $dateAfter = clone $dateToCompare;
        // 10 days after the date to compare
        $dateAfter->add(new DateInterval('P10D'));

        return [
            [$dateToCompare, $dateBefore, $dateAfter],
            [$dateToCompare, $dateAfter, $dateBefore],
            [$dateToCompare, $dateBefore, null],
            [$dateToCompare, null, $dateBefore],
            [$dateToCompare, null, null],
            [null, null, null]
        ];
    }

    /**
     * @dataProvider getDatesToCompare
     *
     * @param $dateToCompare
     * @param $startDate
     * @param $endDate
     *
     * @throws \Exception
     */
    public function testIsDateInInterval($dateToCompare, $startDate, $endDate)
    {
        $dateHelper = new Date();

        $this->assertIsBool($dateHelper->isDateInInterval($dateToCompare, $startDate, $endDate));
    }

    /**
     * @dataProvider getDatesToCompare
     *
     * @param $dateToCompare
     * @param $endDate
     *
     * @throws \Exception
     */
    public function testIsDateBefore($dateToCompare, $endDate)
    {
        $dateHelper = new Date();

        $this->assertIsBool($dateHelper->isDateBefore($dateToCompare, $endDate));
    }

    /**
     * @dataProvider getDatesToCompare
     *
     * @param $dateToCompare
     * @param $startDate
     *
     * @throws \Exception
     */
    public function testIsDateAfter($dateToCompare, $startDate)
    {
        $dateHelper = new Date();

        $this->assertIsBool($dateHelper->isDateAfter($dateToCompare, $startDate));
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getSingleDates()
    {
        return [
            [new DateTime('now')],
            [new DateTime('2019-12-31')],
            [new DateTime('2019-02-29')],
            [new DateTime('1976-02-29')],
            [new DateTime('542-06-24')],
            [new DateTime('1926-02-16')],
            [null]
        ];
    }

    /**
     * @dataProvider getSingleDates
     *
     * @param $dateToTest
     *
     * @throws \Exception
     */
    public function testCurrentDayOfYear($dateToTest)
    {
        $dateHelper = new Date();

        $this->assertSame(
            $dateHelper->currentDayOfYear($dateToTest) + 1,
            $dateHelper->currentDayOfYear($dateToTest, true)
        );
    }

    /**
     * @dataProvider getSingleDates
     *
     * @param $dateToTest
     *
     * @throws \Exception
     */
    public function testIsWeekEnd($dateToTest)
    {
        $dateHelper = new Date();

        $this->assertIsBool($dateHelper->isWeekEnd($dateToTest));
    }

    /**
     * @dataProvider getSingleDates
     *
     * @param $dateToTest
     *
     * @throws \Exception
     */
    public function testIsLeapYear($dateToTest)
    {
        $dateHelper = new Date();

        $this->assertIsBool($dateHelper->isLeapYear($dateToTest));
    }
}