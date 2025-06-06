<?php

$query = 'SELECT * 
    FROM applications
    ORDER BY name';
$result = mysqli_query($connect, $query);

$applications = array();

while($record = mysqli_fetch_assoc($result))
{

    $next['id'] = $record['id'];
    $next['name'] = $record['name'];
    $next['avatar'] = application_avatar($record['id'], true);

    $query = 'SELECT * 
        FROM users
        WHERE id = "'.$record['user_id'].'"
        LIMIT 1';
    $result2 = mysqli_query($connect, $query);
    $record2 = mysqli_fetch_assoc($result2);

    $next['user']['first'] = $record2['first'];
    $next['user']['last'] = $record2['last'];
    $next['user']['avatar'] = user_avatar($record2['id'], true);
    
    $applications[] = $next;

}

$data = array(
    'message' => 'Applications retrieved successfully.',
    'error' => false, 
    'applications' => $applications,
);
