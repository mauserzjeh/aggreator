<?php

namespace App\Helpers;

class ScheduleHelper
{

    const DEFAULT_SCHEDULE = [
        'mon' => [
            360, 1080
        ],
        'tue' => [
            360, 1080
        ],
        'wed' => [
            360, 1080
        ],
        'thu' => [
            360, 1080
        ],
        'fri' => [
            360, 1080
        ],
        'sat' => [
            360, 1080
        ],
        'sun' => [
            360, 1080
        ],
    ];

    const WEEKDAYS = [
        'mon' => 'Monday',
        'tue' => 'Tuesday',
        'wed' => 'Wednesday',
        'thu' => 'Thursday',
        'fri' => 'Friday',
        'sat' => 'Saturday',
        'sun' => 'Sunday'
    ];
}
