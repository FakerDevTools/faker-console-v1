<?php

function events_photo($id)
{
    $event = events_fetch($id);
    return $event['photo'] ? $event['photo'] : '/images/no_city.png';
}

function events_fetch($identifier, $field = false)
{

    if(!$identifier) return false;

    global $connect;

    if($field)
    {
        $query = 'SELECT *
            FROM events
            WHERE '.$field.' = "'.addslashes($identifier).'"
            LIMIT 1';
    }
    else
    {
        $query = 'SELECT *
            FROM events
            WHERE id = "'.addslashes($identifier).'"
            LIMIT 1';
    }
    
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}