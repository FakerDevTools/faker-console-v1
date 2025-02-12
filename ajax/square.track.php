<?php

if(
    !isset($_POST['id']) || 
    !isset($_POST['track_id']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}

if($_POST['track'] == "false")
{
    $query = 'DELETE FROM square_track
        WHERE track_id = "'.addslashes($_POST['track_id']).'"
        AND square_id = "'.$_POST['id'].'"';
    mysqli_query($connect, $query);
}
else
{
    $query = 'INSERT INTO square_track (
            track_id,
            square_id
        ) VALUES (
            "'.addslashes($_POST['track_id']).'",
            "'.addslashes($_POST['id']).'"
        )';
    mysqli_query($connect, $query);
}

$data = array('message' => 'Square has been updated.', 'error' => false);