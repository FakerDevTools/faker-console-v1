<?php

function user_avatar($id, $absolute = false)
{
    $user = user_fetch($id);
    return $user['avatar'] ? $user['avatar'] : ($absolute ? ENV_ACCOUNT_DOMAIN : '').'/images/no_avatar.png';
}

function user_name($id)
{
    $user = user_fetch($id);
    return $user['first'].' '.$user['last'];
}

function user_fetch($identifier, $field = false)
{

    global $connect;

    if($field)
    {
        $query = 'SELECT *
            FROM users
            WHERE '.$field.' = "'.addslashes($identifier).'"
            LIMIT 1';
    }
    else
    {
        $query = 'SELECT *
            FROM users
            WHERE id = "'.addslashes($identifier).'"
            OR email = "'.addslashes($identifier).'"
            OR github_username = "'.addslashes($identifier).'"
            OR (reset_hash = "'.addslashes($identifier).'" AND reset_hash != "")
            OR (verify_hash = "'.addslashes($identifier).'" AND verify_hash != "")
            LIMIT 1';
    }
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}

function user_set_city($user_id, $city_id = false)
{

    global $connect; 
    
    if($city_id)
    {

        $query = 'UPDATE users SET
            city_id = '.$city_id.'
            WHERE id = '.$user_id.'
            LIMIT 1';
        mysqli_query($connect, $query);

    }
    else
    {

        $query = 'SELECT cities.id
            FROM cities
            INNER JOIN city_user 
            ON city_user.city_id = cities.id
            WHERE city_user.user_id = '.$user_id.'
            AND deleted_at IS NULL
            ORDER BY created_at DESC
            LIMIT 1';
        $result = mysqli_query($connect, $query);

        if(mysqli_num_rows($result))
        {
            $record = mysqli_fetch_assoc($result);
            user_set_city($user_id, $record['id']);
        }

    }

}
