<?php

declare(strict_types = 1);

namespace AdsSquared;

class Messages {
    const INVALID_START_DATE = 'Required parameter $startDate is not resolving to a valid date';
    const INVALID_END_DATE = 'Required parameter $endDate is not resolving to a valid date';
    const INVALID_HOUR = 'Required parameter $hour must be between the values of 0 - 23';
    const INCORRECT_DATE_ORDER = '$startDate is before $endDate';
    const EMPTY_JOB_ID = 'A jobID has not been set';
    const UNEXPECTED_RESPONSE = 'Unexpected response from server: ';
}
