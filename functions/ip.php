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

function ip_add($ip_address)
{

    global $connect, $_key;

    if(!$ip_address) return false;

    // Fetch matching IP record. If it does not exist add IP.
    $query = 'SELECT id
        FROM ips
        WHERE address = "'.$ip_address.'"
        AND application_id = "'.$_kery['application_id'].'"
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
                "'.$_key['application_id'].'",
                "pending",
                NOW(),
                NOW()
            )';
        mysqli_query($connect, $query);

        $ip_id = mysqli_insert_id($connect);

        return ip_fetch($ip_id, $_key['application_id']);

    }
    else
    {

        $record = mysqli_fetch_assoc($result);

        return $record;

    }

}