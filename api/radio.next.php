<?php

if(!isset($_GET['key']) || !is_numeric($_GET['key']))
{
    $data = array('message' => 'No city ID specified.', 'error' => false);
    return;
}


$query = 'SELECT id,
    name,
    schedule_id,
    city_id,
    play_at,
    status
    FROM schedule_logs
    WHERE play_at < "'.date_now('MYSQL').'"
    AND city_id = "'.$_GET['key'].'"
    ORDER BY play_at DESC
    LIMIT 1';
$result = mysqli_query($connect, $query);

$log = mysqli_fetch_assoc($result);

$data = array(
    'message' => 'Next radio log has been loaded.',
    'error' => false, 
    'log' => $log,
);

