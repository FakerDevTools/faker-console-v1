<?php

if(
    !isset($_POST['id']) || 
    !isset($_POST['road_id']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}

if($_POST['road'] == "false")
{
    $query = 'DELETE FROM road_square
        WHERE road_id = "'.addslashes($_POST['road_id']).'"
        AND square_id = "'.$_POST['id'].'"';
    mysqli_query($connect, $query);
}
else
{
    $query = 'INSERT INTO road_square (
            road_id,
            square_id
        ) VALUES (
            "'.addslashes($_POST['road_id']).'",
            "'.addslashes($_POST['id']).'"
        )';
    mysqli_query($connect, $query);
}

$data = array('message' => 'Square has been updated.', 'error' => false);