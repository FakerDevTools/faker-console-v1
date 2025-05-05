<?php

function api_ip_address($ip_address, $key)
{

    global $connect;

    if(!$ip_address) return false;

    $query = 'SELECT application_id
        FROM keys
        WHERE hash = "'.$key.'"
        AND deleted_at IS NULL';
    $result = mysqli_query($connect, $query);

    $record = mysqli_fetch_assoc($result);

    $application_id = $record['application_id'];

    $query = 'SELECT id
        FROM ips
        WHERE address = "'.$ip_address.'"
        AND application_id = "'.$application_id.'"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result)) return false;

    $record = mysqli_fetch_assoc($result);

    return $record['id'];

}

function api_key($key)
{

    global $connect;

    if(!$key) return false;

    $query = 'SELECT id
        FROM keys
        WHERE hash = "'.$key.'"
        AND deleted_at IS NULL';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result)) return false;

    $record = mysqli_fetch_assoc($result);

    return $record['id'];

}

function api_call($key, $ip_address)
{
    
}