<?php

$query = 'SELECT * 
    FROM colours 
    ORDER BY name'; 
$result = mysqli_query($connect, $query);

$colorArray = array();

if($result){

    $i = 0;

    while($colour = mysqli_fetch_assoc($result)){
        $colorArray[$i]['id'] = $colour['id'];
        $colorArray[$i]['name'] = $colour['name'];
        $colorArray[$i]['rgb'] = $colour['rgb'];
        $i++;
    }

    $data = array(
        'message' => 'Colours retrieved successfully.',
        'error' => false, 
        'colours' => $colorArray,
    );
    
} else {
    $data = array(
        'message' => 'Error retrieving colours detail.',
        'error' => true,
        'colours' => null,
    );
}