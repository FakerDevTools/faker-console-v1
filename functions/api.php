<?php

function api_check_ip_address($ip_address, $key)
{

    global $connect;

    if(!$ip_address) return false;

    // Fetch key or return false
    $query = 'SELECT application_id
        FROM `keys` 
        WHERE hash = "'.$key.'"
        AND deleted_at IS NULL';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result)) return false;

    $record = mysqli_fetch_assoc($result);

    $application_id = $record['application_id'];

    // Check if there are any approved IPs, if there are none than no IP
    // proteection is in place. If there is at least one, check IP address.
    $query = 'SELECT id
        FROM ips
        WHERE application_id = "'.$application_id.'"
        AND status = "allowed"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {

        ip_add($ip_address, $key);
        return true;

    }

    // Fetch mathing IP record that has status allowed. If it does not exist
    // add IP and return false.
    $query = 'SELECT id
        FROM ips
        WHERE address = "'.$ip_address.'"
        AND application_id = "'.$application_id.'"
        AND status = "allowed"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {
        
        ip_add($ip_address, $key);
        return false;

    }

    $record = mysqli_fetch_assoc($result);

    return $record['id'];

}

function api_check_key($key)
{

    global $connect;

    if(!$key) return false;

    $query = 'SELECT id
        FROM `keys`
        WHERE hash = "'.$key.'"
        AND deleted_at IS NULL';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result)) return false;

    $record = mysqli_fetch_assoc($result);

    return $record['id'];

}

function api_call($key = false, $ip_address = false)
{

    global $connect;

    $result = 'success';

    if($key) $key = key_fetch($key, false);
    elseif(isset($_GET['key'])) $key = key_fetch($_GET['key'], false);

    if(!is_array($key) or !count($key))
    {
        $key = 0;
        $result = 'key';
    }

    if($ip_address) $ip_address = ip_fetch($ip_address, false);

    if(!is_array($ip_address) or !count($ip_address)) 
    {
        $ip_address = 0;
        $result = 'ip';
    }

    $query = 'INSERT INTO calls (
            url,
            ip,
            `key`,
            ip_id,
            key_id,
            result,
            created_at,
            updated_at
        ) VALUES (
            "'.string_url().'",
            "'.$ip_address['address'].'",
            "'.$key['hash'].'",
            "'.$ip_address['id'].'",
            "'.$key['id'].'",
            "'.$result.'",
            NOW(),
            NOW()
        )';

    mysqli_query($connect, $query);

}