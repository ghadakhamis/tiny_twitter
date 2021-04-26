<?php
    return [
        'attempts' => env('FAILED_LOGIN_ATTEMPS',5),
        'blockedTimeInMinutes' => env('BLOCKED_TIME_IN_MINUTES',30)
    ];