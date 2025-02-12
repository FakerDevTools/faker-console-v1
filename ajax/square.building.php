<?php

if(
    !isset($_POST['id']) || 
    !isset($_POST['building_id']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}

$query = 'UPDATE squares SET 
    building_id = '.($_POST['building'] == "false" ? 0 : $_POST['building_id']).'
    WHERE id = "'.$_POST['id'].'"
    LIMIT 1';
mysqli_query($connect, $query);

$data = array('message' => 'Square has been updated.', 'error' => false);