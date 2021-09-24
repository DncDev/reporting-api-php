<?php
/**
 * Report class which facilitates the retrieval of reports
 * from the AdsSquared Reporting Server
 */
declare(strict_types = 1);

namespace AdsSquared\Facade;

use AdsSquared\Classes\{DailyReport, GenericReport, HourlyReport};

class Reporter {
    /**
     * @param string $username
     * @param string $apiKey
     * @param string $startDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $endDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $market - May be any valid market parameter. Check your partner docs
     * @param int $timeout - Timeout in milliseconds. How long code will attempt to check the AdsSquared
     *                       reporting server before giving up.
     *
     * @return DailyReport
     */
    public static function Device($username, $apiKey, $startDate, $endDate, $market = null, $timeout = 3000) {
        $report = new DailyReport('device', $username, $apiKey, $startDate, $endDate, $market, $timeout);

        return $report;
    }

    /**
     * @param string $username
     * @param string $apiKey
     * @param string $startDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $endDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $market - May be any valid market parameter. Check your partner docs
     * @param int $timeout - Timeout in milliseconds. How long code will attempt to check the AdsSquared
     *                       reporting server before giving up.
     *
     * @return DailyReport
     */
    public static function DeviceType($username, $apiKey, $startDate, $endDate, $market = null, $timeout = 3000) {
        $report = new DailyReport('devicetype', $username, $apiKey, $startDate, $endDate, $market, $timeout);

        return $report;
    }

    /**
     * @param string $username
     * @param string $apiKey
     * @param string $startDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $endDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $market - May be any valid market parameter. Check your partner docs
     * @param int $timeout - Timeout in milliseconds. How long code will attempt to check the AdsSquared
     *                       reporting server before giving up.
     *
     * @return DailyReport
     */
    public static function Source($username, $apiKey, $startDate, $endDate, $market = null, $timeout = 3000) {
        $report = new DailyReport('source', $username, $apiKey, $startDate, $endDate, $market, $timeout);

        return $report;
    }

    /**
     * @param string $username
     * @param string $apiKey
     * @param string $startDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $endDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $market - May be any valid market parameter. Check your partner docs
     * @param int $timeout - Timeout in milliseconds. How long code will attempt to check the AdsSquared
     *                       reporting server before giving up.
     *
     * @return DailyReport
     */
    public static function SourceType($username, $apiKey, $startDate, $endDate, $market = null, $timeout = 3000) {
        $report = new DailyReport('sourcetype', $username, $apiKey, $startDate, $endDate, $market, $timeout);

        return $report;
    }

    /**
     * @param string $username
     * @param string $apiKey
     * @param string $startDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $endDate - Can be any valid date string that the DateTime constructor can parse
     * @param int $hour - The hour you're requesting. Valid values are 0 - 23
     * @param string $market - May be any valid market parameter. Check your partner docs
     * @param int $timeout - Timeout in milliseconds. How long code will attempt to check the AdsSquared
     *                       reporting server before giving up.
     *
     * @return HourlyReport
     */
    public static function DeviceHourly($username, $apiKey, $startDate, $endDate, $hour = 0, $market = null, $timeout = 3000) {
        $report = new HourlyReport('devicehourly', $username, $apiKey, $startDate, $endDate, $hour, $market, $timeout);

        return $report;
    }

    /**
     * @param string $username
     * @param string $apiKey
     * @param string $startDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $endDate - Can be any valid date string that the DateTime constructor can parse
     * @param int $hour - The hour you're requesting. Valid values are 0 - 23
     * @param string $market - May be any valid market parameter. Check your partner docs
     * @param int $timeout - Timeout in milliseconds. How long code will attempt to check the AdsSquared
     *                       reporting server before giving up.
     *
     * @return HourlyReport
     */
    public static function SourceHourly($username, $apiKey, $startDate, $endDate, $hour = 0, $market = null, $timeout = 3000) {
        $report = new HourlyReport('sourcehourly', $username, $apiKey, $startDate, $endDate, $hour, $market, $timeout);

        return $report;
    }
    
    /**
     * @param string $username
     * @param string $apiKey
     * @param string $startDate - Can be any valid date string that the DateTime constructor can parse
     * @param string $endDate - Can be any valid date string that the DateTime constructor can parse
     * @param int $hour - The hour you're requesting. Valid values are 0 - 23
     * @param string $market - May be any valid market parameter. Check your partner docs
     * @param int $timeout - Timeout in milliseconds. How long code will attempt to check the AdsSquared
     *                       reporting server before giving up.
     *
     * @return HourlyReport
     */
    public static function DeviceTypeHourly($username, $apiKey, $startDate, $endDate, $hour = 0, $market = null, $timeout = 3000) {
        $report = new HourlyReport('devicetypehourly', $username, $apiKey, $startDate, $endDate, $hour, $market, $timeout);

        return $report;
    }
    
    /**
     * @param string $username
     * @param string $apiKey
     * @param int $timeout - Timeout in milliseconds. How long code will attempt to check the AdsSquared
     *                       reporting server before giving up.
     *
     * @return HourlyReport
     */
    public static function Tags($username, $apiKey, $timeout = 3000) {
        $report = new GenericReport('tags', $username, $apiKey, $timeout);

        return $report;
    }
    
    public static function PartnerTQ($username, $apiKey, $startDate, $endDate, $timeout = 3000) {
        $report = new DailyReport('partnertq', $username, $apiKey, $startDate, $endDate, '', $timeout);
    }
}
