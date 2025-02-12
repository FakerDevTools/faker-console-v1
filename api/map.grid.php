<?php

if(!isset($_GET['key']) || !is_numeric($_GET['key']))
{
    $data = array('message' => 'No city ID specified.', 'error' => false);
    return;
}

// Sample URL: http://local.api.brickmmo.com:7777/map/grid/1

$data = array(
    'message' => 'Grid retrieved successfully.',
    'error' => false, 
    'grid' => 'array',
);