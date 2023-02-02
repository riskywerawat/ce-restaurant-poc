<?php

return [

    'demo_mode' => env('DEMO_MODE', false),
    'start_days' => env('TRADE_START_DAYS', 2), // can trade start from ... days
    'end_days' => env('TRADE_END_DAYS', 30), // can trade until ... days

];
