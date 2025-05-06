<?php

function key_fetch($identifier, $application = true)
{

    if(!$identifier) return false;

    global $connect, $_application;

    $query = 'SELECT *
        FROM `keys`
        WHERE (
            id = "'.addslashes($identifier).'"
            OR hash = "'.addslashes($identifier).'"
        ) 
        '.($application ? 'AND application_id = "'.$_application['id'].'"' : '').'
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}
