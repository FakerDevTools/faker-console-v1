<?php

$query = 'SELECT *
    FROM crons
    ORDER BY `when`';
$result = mysqli_query($connect, $query);

$daya = array();

while($record = mysqli_fetch_assoc($result))
{
    $data[] = $record;
}

$data = array(
    'message' => 'Cron list has been loaded.', 
    'error' => true,
    'crons' => $data,
);

