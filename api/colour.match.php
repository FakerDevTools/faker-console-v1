<?php

if(isset($_GET['key'])) {

    $query = 'SELECT * 
    FROM colours 
    ORDER BY name'; 

    $result = mysqli_query($connect, $query);

    $colorArray = array();

    if($result){

        header("Content-Type: application/json; charset=UTF-8");

        $i = 0;

        while($colour = mysqli_fetch_assoc($result)){
            $colorArray[$i]['id'] = $colour['id'];
            $colorArray[$i]['name'] = $colour['name'];
            $colorArray[$i]['rgb'] = $colour['rgb'];
            $i++;
        }

        $colorDistanceArray = $colorArray;

        foreach($colorArray as $index => $color){

            $rgbColorDistance = colour_distance($color['rgb'], $_GET['key']);

            $colorDistanceArray[$index]['colorDistance'] = $rgbColorDistance;
        }
        
        usort($colorDistanceArray, function($first, $second) {
            if ($first['colorDistance'] == $second['colorDistance']) return 0;
            return ($first['colorDistance'] < $second['colorDistance']) ? -1 : 1;
        });

        $colorMatch = array();

        for($i = 0; $i < 4; $i++){
            $colorMatch[$i] = $colorDistanceArray[$i];
        }

        $data = array(
            'message' => 'Colours retrieved successfully.',
            'error' => false, 
            'colours' => $colorMatch,
        );
        
    } else {
        $data = array(
            'message' => 'Error retrieving colours detail.',
            'error' => true,
            'colours' => null,
        );
    }
}