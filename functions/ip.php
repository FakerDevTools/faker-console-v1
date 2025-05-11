<?php

function ip_fetch($identifier, $application = true)
{

    if(!$identifier) return false;

    global $connect, $_application;

    $query = 'SELECT *
        FROM ips
        WHERE (
            id = "'.addslashes($identifier).'"
            OR address = "'.addslashes($identifier).'"
        )
        '.($application ? 'AND application_id = "'.$_application['id'].'"' : '').'
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}

function ip_add($ip_address, $key)
{

    global $connect;

    if(!$ip_address || !$key) return false;

    // Fetch key or return false
    $query = 'SELECT application_id
        FROM `keys`
        WHERE hash = "'.$key.'"
        AND deleted_at IS NULL';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result)) return false;

    $record = mysqli_fetch_assoc($result);

    $application_id = $record['application_id'];

    // Fetch mathing IP record that has status allowed. If it does not exist
    // add IP and return false.
    $query = 'SELECT id
        FROM ips
        WHERE address = "'.$ip_address.'"
        AND application_id = "'.$application_id.'"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {
        
        $query = 'INSERT INTO ips (
                address,
                application_id,
                status,
                created_at,
                updated_at
            ) VALUES (
                "'.$ip_address.'",
                "'.$application_id.'",
                "pending",
                NOW(),
                NOW()
            )';
        mysqli_query($connect, $query);

        return mysqli_insert_id($connect);

    }
    else
    {

        $record = mysqli_fetch_assoc($result);

        return $record['id'];

    }

}