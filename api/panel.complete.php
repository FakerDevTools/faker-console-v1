<?php

// Check if 'city_id' is present in the GET request
if (isset($_GET['city'])) {

    // Escape and validate the input to prevent SQL injection
    $city_id = intval($_GET['city']);  // Ensures only integer values are used

    // Query to fetch panel data based on city_id
    $query = "SELECT * FROM panels WHERE city_id = " . $city_id;

    // Execute the query
    $result = mysqli_query($connect, $query);

    // Initialize an empty array to store panel data
    $panelArray = array();

    // Check if the query execution was successful
    if ($result) {

        // Set the response header to return JSON data
        header("Content-Type: application/json");

        // Fetch each panel record and store it in the array
        $i = 0;
        while ($panel = mysqli_fetch_assoc($result)) {
            $panelArray[$i]['id'] = $panel['id'];
            $panelArray[$i]['port'] = $panel['port'];
            $panelArray[$i]['cartridge'] = $panel['cartridge'];
            $panelArray[$i]['city_id'] = $panel['city_id'];
            $panelArray[$i]['value'] = $panel['value'];
            $i++;
        }

        // Create the response data with the panel details
        $data = array(
            'message' => 'Panel data retrieved successfully.',
            'error' => false,
            'panel' => $panelArray,
        );
    } else {
        // Handle query execution failure (could be due to an invalid query or database error)
        $data = array(
            'message' => 'Error retrieving panel data from the database.',
            'error' => true,
            'panel' => null,
            'sql_error' => mysqli_error($connect), // Include the actual SQL error message
        );
    }
} else {
    // Handle the case where 'city_id' is missing in the request
    $data = array(
        'message' => 'Missing required parameter: city_id.',
        'error' => true,
        'panel' => null,
    );
}
