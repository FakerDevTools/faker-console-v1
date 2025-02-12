<?php

if(!isset($_GET['key']) || !is_numeric($_GET['key']))
{
    $data = array(
        'message' => 'Invalid colour.',
        'error' => true,
        'colour' => '',
    );

    return;
}

$query = 'SELECT colours.id, 
    colours.name, 
    rgb, 
    is_trans, 
    rebrickable_id, 
    externals.name AS external_name, 
    source
    FROM colours 
    INNER JOIN externals
    ON colours.id = externals.colour_id
    WHERE colours.id = "'.addslashes( $_GET["key"] ).'"';
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) === 0) 
{
    $data = array(
        'message' => 'Colour code not found.',
        'error' => true,
        'colours' => '',
    );

    return;
}

$colour = mysqli_fetch_aSSOC($result);

$data = array(
    'message' => 'Colour code retrieved successfully.',
    'error' => false,
    'colour' => $colour,
);