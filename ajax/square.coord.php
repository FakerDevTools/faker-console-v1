<?php

if(!isset($_POST['id']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}

$square = square_fetch($_POST['id']);

if($_POST['coord'] == "false")
{
    $query = 'DELETE FROM coords
        WHERE x = "'.$square['x'].'"
        AND y = "'.$square['y'].'"';
    mysqli_query($connect, $query);
}
else
{
    $query = 'INSERT INTO coords (
            x,
            y,
            city_id,
            type,
            created_at,
            updated_at
        ) VALUES (
            "'.$square['x'].'",
            "'.$square['y'].'",
            "'.$_city['id'].'",
            "car",
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);
}

$data = array('message' => 'Square has been updated.', 'error' => false);