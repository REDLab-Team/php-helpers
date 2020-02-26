<?php

namespace Redlab\Helper\Test;

use \DateTime,
    \DateInterval,
    \PHPUnit\Framework\TestCase,
    Redlab\Helper\Date;

/**
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class DateTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testIsDateInInterval()
    {
        $dateToCompare = new DateTime();
        $startDate = clone $dateToCompare;
        // 10 days before the date to compare
        $startDate->sub(new DateInterval('P10D'));
        $endDate = clone $dateToCompare;
        // 10 days after the date to compare
        $endDate->add(new DateInterval('P10D'));

        $this->assertTrue(Date::isDateInInterval($dateToCompare, $startDate, $endDate));
        $this->assertTrue(Date::isDateInInterval($dateToCompare, $startDate));
        $this->assertTrue(Date::isDateInInterval($dateToCompare, null, $endDate));

        $this->assertFalse(Date::isDateInInterval($dateToCompare, $endDate, $startDate));
        $this->assertFalse(Date::isDateInInterval($dateToCompare, $endDate));
        $this->assertFalse(Date::isDateInInterval($dateToCompare, null, $startDate));

        $this->assertFalse(Date::isDateInInterval($dateToCompare));
    }
}