<?php

$query = 'SELECT * 
    FROM colours 
    ORDER BY name'; 

$result = mysqli_query($connect, $query);

$coloursCount = mysqli_num_rows($result);

$random = rand(1, $coloursCount);

$query = 'SELECT colours.id, colours.name, rgb, is_trans, rebrickable_id, externals.name AS external_name, source
FROM colours 
INNER JOIN externals
ON colours.id = externals.colour_id
WHERE colours.id = '.$random;    

$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) === 0) {
    $query = 'SELECT * 
    FROM colours 
    WHERE id = '.$random.' LIMIT 1'; 

    $result = mysqli_query($connect, $query);

    $colourObject = mysqli_fetch_assoc($result);

    if ($result) {

        header("Content-Type: application/json; charset=UTF-8");

        $colour = array(
            'id' => $colourObject['id'],
            'name' => $colourObject['name'],
            'rgb' => $colourObject['rgb'],
            'is_trans' => $colourObject['is_trans'],
            'rebrickable_id' => $colourObject['rebrickable_id']
        );

        $data = array(
            'message' => 'Random colour retrieved successfully.',
            'error' => false, 
            'colours' => $colour,
        );

    } else {
        $data = array(
            'message' => 'Error retrieving random colour detail.',
            'error' => true,
            'colours' => null,
        );
    }
}

else{
    if ($result) {

        header("Content-Type: application/json; charset=UTF-8");

        $colourObject = mysqli_fetch_assoc($result);

        $colour = array(
            'id' => $colourObject['id'],
            'name' => $colourObject['name'],
            'rgb' => $colourObject['rgb'],
            'is_trans' => $colourObject['is_trans'],
            'rebrickable_id' => $colourObject['rebrickable_id'],
            'external_ids' => array(),
        );

        mysqli_data_seek($result, 0);

        while ($externals = mysqli_fetch_assoc($result)) {
            $colour['external_ids'][] = array(
                'source' => $externals['source'],
                'name' => $externals['external_name']
            );
        }

        $data = array(
            'message' => 'Random colour retrieved successfully.',
            'error' => false, 
            'colours' => $colour,
        );

    } else {
        $data = array(
            'message' => 'Error retrieving randopm colour detail.',
            'error' => true,
            'colours' => null,
        );
    }
}