<?php

function api_check_ip_address()
{

    global $connect, $_application, $_key;

    if(!$_key) return false;

    $ip_address = network_ip_address();

    // Check if there are any approved IPs, if there are none, no IP
    // proteection is in place. If there is at least one, check IP address.
    $query = 'SELECT *
        FROM ips
        WHERE application_id = "'.$_key['application_id'].'"
        AND status = "allowed"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {

        $record = ip_add($ip_address, $_key['id']);
        $record['filtering'] = false;
        return $record;

    }

    // Fetch mathing IP record that has status allowed. If it does not exist
    // add IP and return false.
    $query = 'SELECT *
        FROM ips
        WHERE address = "'.$ip_address.'"
        AND application_id = "'.$_application['id'].'"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {
        
        $record = ip_add($ip_address, $key);
        $record['filtering'] = true;
        return $record;

    }

    $record = mysqli_fetch_assoc($result);
    $record['filtering'] = true;

    return $record;

}

function api_check_key()
{

    global $connect;

    $key = isset($_GET['key']) ? $_GET['key'] : false;

    if($key)
    {

        $query = 'SELECT *
            FROM `keys`
            WHERE hash = "'.$key.'"
            AND deleted_at IS NULL';
        $result = mysqli_query($connect, $query);

        if(mysqli_num_rows($result))
        {
            $key = mysqli_fetch_assoc($result);
        }
        else
        {
            $key = false;
        }

    }

    return $key;

}

function api_call($key = false, $ip_address = false, $result = 'success')
{

    global $connect;

    if($key) $key = key_fetch($key, false);

    if(!is_array($key) or !count($key))
    {
        $key = array(
            'id' => 0,
            'hash' => ''
        );
        if($result == 'success') $result = 'key';
    }

    if($ip_address) $ip_address = ip_fetch($ip_address, false);

    if(!is_array($ip_address) or !count($ip_address)) 
    {
        $ip_address = array(
            'id' => 0,
            'address' => network_ip_address()
        );
        if($result == 'success') $result = 'ip';
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
            "'.network_url().'",
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