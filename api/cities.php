<?php

$query = 'SELECT * 
    FROM cities
    ORDER BY name';
$result = mysqli_query($connect, $query);

$cities = array();

while($record = mysqli_fetch_assoc($result))
{
    $next['id'] = $record['id'];
    $next['name'] = $record['name'];
    $next['url'] = ENV_CONSOLE_DOMAIN.'/profile/'.$record['url'];
    $next['width'] = $record['width'];
    $next['height'] = $record['height'];
    $next['date_at'] = $record['date_at'];
    $next['date_multiplier'] = $record['date_multiplier'];
    $next['avatar'] = city_avatar($record['id'], true);

    $query = 'SELECT * 
        FROM users
        WHERE id = "'.$record['user_id'].'"
        LIMIT 1';
    $result2 = mysqli_query($connect, $query);
    $record2 = mysqli_fetch_assoc($result2);

    $next['user']['first'] = $record2['first'];
    $next['user']['last'] = $record2['last'];
    $next['user']['url'] = ENV_ACCOUNT_DOMAIN.'/profile/'.$record2['url'];
    $next['user']['avatar'] = user_avatar($record2['id'], true);
    
    $cities[] = $next;
}

$data = array(
    'message' => 'Cities retrieved successfully.',
    'error' => false, 
    'cities' => $cities,
);
