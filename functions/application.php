<?php

function application_fetch($identifier)
{

    if(!$identifier) return false;

    global $connect;

    $query = 'SELECT *
        FROM applications
        WHERE id = "'.addslashes($identifier).'"
        OR name = "'.addslashes($identifier).'"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}
