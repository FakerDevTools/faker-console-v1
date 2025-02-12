<?php

if(!isset($_GET['key']) || !is_numeric($_GET['key']))
{
    $data = array('message' => 'No city ID specified.', 'error' => false);
    return;
}


$query = 'SELECT schedules.*,
    schedule_types.name AS type_name
    FROM schedules
    INNER JOIN schedule_types
    ON schedules.type_id = schedule_types.id
    WHERE city_id = "'.$_GET['key'].'"
    ORDER BY minute';
$result = mysqli_query($connect, $query);

$data = array();

while($schedule = mysqli_fetch_assoc($result))
{
    $data[] = $schedule;
}

$data = array(
    'message' => 'Schedule has been loaded.',
    'error' => false, 
    'schedule' => $data,
);

