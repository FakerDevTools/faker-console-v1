<?php

if(!isset($_GET['key']) || !is_numeric($_GET['key']))
{
    $data = array('message' => 'No city ID specified.', 'error' => false);
    return;
}

$query = 'TRUNCATE schedule_logs';
mysqli_query($connect, $query);

$now = time();
$now -= $now % 60;

$counter = 0;
$data = array();

for($i = 0; $i < 1; $i ++)
{

    $minute_play = date('i', $now);
    $minute_lookup = str_pad($minute_play % 15, 2, '0', STR_PAD_LEFT);
    $play = mktime(
        date('h', $now),
        $minute_play, 
        0);

    // echo 'Time: '.$now.'<br>';
    // echo 'Date: '.date_to_format($now, 'FULL').'<br>';
    // echo 'Minute: '.$minute_play.'<br>';
    // echo 'Lookup: '.$minute_lookup.'<br>';
    // echo 'Play: '.date_to_format($play, 'FULL').'<br>';

    $query = 'SELECT *
        FROM schedule_logs
        WHERE city_id = "'.$_GET['key'].'"
        AND play_at = "'.date_to_format($play, 'MYSQL').'"';
    $result = mysqli_query($connect, $query);

    // echo 'Queued: '.mysqli_num_rows($result).'<br>';
    // echo 'Query: '.$query.'<br>';
    
    // If a log does not exist for this play date
    if(!mysqli_num_rows($result))
    {

        $query = 'SELECT schedules.*,
            schedule_types.name AS type_name
            FROM schedules
            LEFT JOIN schedule_types 
            ON schedules.type_id = schedule_types.id
            WHERE minute = "'.$minute_lookup.'"
            AND city_id = "'.$_GET['key'].'"
            LIMIT 1';
        $result = mysqli_query($connect, $query);

        // echo 'Scheudle Exists: '.mysqli_num_rows($result).'<br>';

        // If a schedule exists for this minute
        if(mysqli_num_rows($result))
        {

            $schedule = mysqli_fetch_assoc($result);

            $query = 'INSERT INTO schedule_logs (
                    name,
                    schedule_id,
                    city_id,
                    play_at,
                    created_at,
                    updated_at
                ) VALUES (
                    "'.$schedule['type_name'].' at '.$minute_play.'",
                    "'.$schedule['id'].'",
                    "'.$schedule['city_id'].'",
                    "'.date_to_format($play, 'MYSQL').'",
                    "'.date_now().'",
                    "'.date_now().'"
                )';
            mysqli_query($connect, $query);

            $query = 'SELECT *
                FROM schedule_logs
                WHERE id = "'.mysqli_insert_id($connect).'"
                LIMIT 1';
            $result = mysqli_query($connect, $query);

            $log = mysqli_fetch_assoc($result);

            radio_script($log['id'], $_GET['key']);
            radio_mp3($log['id']);

            $data[] = $log;

            $counter ++;

        }
        
    }

    $now += 60;

}

$data = array(
    'message' => $counter.' new radio logs have been scheduled.',
    'error' => false, 
    'logs' => $data,
);
