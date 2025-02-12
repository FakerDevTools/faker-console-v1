<?php

function colour_distance($colorArray, $colourSearch) {

    $colorArray = colour_hex_to_rgb($colorArray);
    $colourSearch = colour_hex_to_rgb($colourSearch);

    $redDifference = $colorArray[0] - $colourSearch[0];
    $greenDifference = $colorArray[1] - $colourSearch[1];
    $blueDifference = $colorArray[2] - $colourSearch[2];

    return sqrt(($redDifference ** 2) + ($greenDifference ** 2) + ($blueDifference ** 2));       
}

function colour_hex_to_rgb($hex) {

    if(strlen($hex) === 3){
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return [$r, $g, $b];
}