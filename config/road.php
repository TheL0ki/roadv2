<?php

return [

    'slack_webhook_url' => env('SLACK_WEBHOOK_URL'),

    'notify_shift_id' => env('SLACK_NOTIFY_SHIFT_ID'),

    'shift_report_shift_id' => env('SHIFT_REPORT_SHIFT_ID'),

    'shift_report_emails' => array_values(array_filter(array_map(
        trim(...),
        explode(',', (string) env('SHIFT_REPORT_EMAILS', '')),
    ))),

];
