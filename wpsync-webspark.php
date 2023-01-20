<?php
/**
 * Plugin Name: wpsync-webspark
 * Description: The plugin receives product balances through the API
 * Version: 1.0
 * Author: Oleksandr Burkhan
 *
 */

require_once __DIR__ . '/bootstrap.php';

use Wpsync\Controller\SyncController;

if (! wp_next_scheduled('sync_task_hourly')) {
    wp_schedule_event(time(), 'hourly', 'sync_task_hourly');
}

add_action('sync_task_hourly', 'startSync', 10, 3);

function startSync(): void
{
    SyncController::getInstance()->sync();
}

add_filter('cron_schedules', 'customInterval');

function customInterval($schedule)
{
    $schedule['every_minute'] = array(
        'interval' => 60,
        'display' => 'Every minute',
    );

    return $schedule;
}
