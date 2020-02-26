<?php

namespace Redlab\Helper;

use \DateTime,
    \DateTimeZone;

/**
 * This class contains methods to convert and compare the dates in the application.
 *
 * @author Jean-Baptiste Motto <motto@redlab.io>
 */
class Date
{
    /**
     * Constants that define dates format
     */
    const STANDARD_DATETIME_FORMAT = 'Y-m-d H:i:s';
    const WEEK_DAY_NUMBER = 'N';
    const CURRENT_YEAR_DAY = 'z';
    const LEAP_YEAR = 'L';

    /**
     * Get formated data from the current date
     *
     * @param string $format
     *
     * @return string
     * @throws \Exception
     */
    public static function dateFromFormat(
        ?DateTime $dateTime,
        string $format
    ): string
    {
        $dateTime = $dateTime ?? new DateTime();

        return $dateTime->format($format);
    }

    /**
     * Check if the parameter is null or a string.
     * If it is a string then it will return a DateTime object else null
     *
     * @param string|null $stringDate
     * @param string $format
     * @param DateTimeZone|null $dateTimeZone
     *     * @return DateTime|null
     * @throws \Exception
     */
    public static function stringToDateTime(
        ?string $stringDate,
        string $format = self::STANDARD_DATETIME_FORMAT,
        ?DateTimeZone $dateTimeZone = null
    ): ?DateTime
    {
        if ($stringDate === null) {
            $dateTime = new DateTime();
            if ($dateTimeZone !== null) {
                $dateTime->setTimezone($dateTimeZone);
            }
        } else {
            $dateTime = DateTime::createFromFormat($format, $stringDate, $dateTimeZone);
        }

        return $dateTime;
    }

    /**
     * Check if the parameter is null or a DateTime object.
     * If it is a DateTime object then if will convert it to the Database string format and return it as a string
     * else null
     *
     * @param DateTime|null $dateTime
     * @param string $format
     * @param bool $nullable
     * @param DateTimeZone|null $dateTimeZone
     *
     * @return string|null
     */
    public static function dateTimeToString(
        ?DateTime $dateTime,
        string $format = self::STANDARD_DATETIME_FORMAT,
        bool $nullable = true,
        ?DateTimeZone $dateTimeZone = null
    ): ?string
    {
        if (! $nullable && $dateTime === null) {
            $dateTime = new DateTime();
            if ($dateTimeZone !== null) {
                $dateTime->setTimezone($dateTimeZone);
            }
        }

        return $dateTime === null ? null : $dateTime->format($format);
    }

    /**
     * Check if the $dateToCompare parameter is between the start date and the end date.
     * If one of the two parameters is null then it will compare the $dateToCompare just with the one that is not null.
     *
     * @param DateTime $dateToCompare
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     *
     * @return bool
     * @throws \Exception
     */
    public static function isDateInInterval(
        DateTime $dateToCompare,
        ?DateTime $startDate = null,
        ?DateTime $endDate = null
    ): bool
    {
        if ($startDate === null && $endDate === null) {
            return false;
        }

        if ($startDate === null xor $endDate === null) {
            return $startDate === null ? $dateToCompare < $endDate : $dateToCompare > $startDate;
        } else {
            return $dateToCompare > $startDate && $dateToCompare < $endDate;
        }
    }

    /**
     * Check if the $dateToCompare parameter is before the $dateEnd parameter.
     * If the $dateEnd parameter is null, then $dateToCompare will be compared with the current date.
     *
     * @param DateTime $dateToCompare
     * @param DateTime|null $dateEnd
     *
     * @return bool
     * @throws \Exception
     */
    public static function isDateBefore(DateTime $dateToCompare, ?DateTime $dateEnd = null): bool
    {
        return $dateToCompare > ($dateEnd ?? new DateTime());
    }

    /**
     * Check if the $dateToCompare parameter is after the $dateStart parameter.
     * If the $dateStart parameter is null, then $dateToCompare will be compared with the current date.
     *
     * @param DateTime $dateToCompare
     * @param DateTime|null $dateStart
     *
     * @return bool
     * @throws \Exception
     */
    public static function isDateAfter(DateTime $dateToCompare, ?DateTime $dateStart = null): bool
    {
        return $dateToCompare < ($dateStart ?? new DateTime());
    }

    /**
     * Return the current date as a string with the selected format passed by parameter.
     *
     * @param string $format
     * @param DateTimeZone|null $dateTimeZone
     *
     * @return string
     * @throws \Exception
     */
    public static function currentDateAsString(
        string $format = self::STANDARD_DATETIME_FORMAT,
        ?DateTimeZone $dateTimeZone = null
    ): string
    {
        return self::dateTimeToString(new DateTime(), $format, true, $dateTimeZone);
    }

    /**
     * Returns the DateTime parameter day of the year
     * If the $dateTime parameter is null then it will check it on the current dateTime
     * The $humanReading parameter is used for a better human comprehension, when set as true.
     * For example January the first will be displayed as 1 instead of 0.
     *
     * @param DateTime|null $dateTime
     * @param bool $humanReading
     *
     * @return int
     * @throws \Exception
     */
    public static function currentDayOfYear(?DateTime $dateTime = null, bool $humanReading = false): int
    {
        $currentDay = (int) self::dateTimeToString($dateTime,self::CURRENT_YEAR_DAY);

        return $humanReading ? ++$currentDay : $currentDay;
    }

    /**
     * Returns true if the DateTime parameter day is saturday or sunday, else false
     * If the $dateTime parameter is null then it will check it on the current dateTime
     *
     * @param DateTime|null $dateTime
     *
     * @return bool
     *
     * @throws \Exception
     */
    public static function isWeekEnd(?DateTime $dateTime = null): bool
    {
        $currentDay = self::dateTimeToString($dateTime, self::WEEK_DAY_NUMBER);

        return (int) $currentDay > 5;
    }

    /**
     * Returns true if the DateTime parameter year is a leap year, else false
     * If the $dateTime parameter is null then it will check it on the current dateTime
     *
     * @param DateTime|null $dateTime
     *
     * @return bool
     * @throws \Exception
     */
    public static function isLeapYear(?DateTime $dateTime = null): bool
    {
        $currentDay = self::dateTimeToString($dateTime, self::LEAP_YEAR);

        return (bool) $currentDay;
    }
}