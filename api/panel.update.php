<?php

// Check if all required GET parameters are present
if (isset($_GET['city']) && isset($_GET['port']) && isset($_GET['value'])) {

    // Escape and validate the input to prevent SQL injection
    $city_id = intval($_GET['city']);
    $port = mysqli_real_escape_string($connect, $_GET['port']);
    $value = mysqli_real_escape_string($connect, $_GET['value']);

    // Check if 'cartridge' is present and handle NULL values
    $cartridge = isset($_GET['cartridge']) ? mysqli_real_escape_string($connect, $_GET['cartridge']) : null;

    // Build the query to update the panel data, considering whether cartridge is NULL
    $query = "
        UPDATE panels 
        SET value = '$value' 
        WHERE city_id = $city_id 
          AND port = '$port' 
          AND " . ($cartridge === null ? "cartridge IS NULL" : "cartridge = '$cartridge'");

    // Execute the query
    $result = mysqli_query($connect, $query);

    // Initialize response array
    $data = array();

    // Check if the query execution was successful
    if ($result) {
        // Check if any rows were affected (i.e., data was updated)
        if (mysqli_affected_rows($connect) > 0) {
            // Successful update, respond with a success message
            $data = array(
                'message' => 'Panel data updated successfully.',
                'error' => false,
            );
        } else {
            // No rows were affected (could mean no matching records found)
            $data = array(
                'message' => 'No matching panel found or no changes made.',
                'error' => true,
            );
        }
    } else {
        // Handle query execution failure (could be due to an invalid query or database error)
        $data = array(
            'message' => 'Error updating panel data in the database.',
            'error' => true,
            'sql_error' => mysqli_error($connect), // Include the actual SQL error message
        );
    }
} else {
    // Handle the case where one or more required parameters are missing in the request
    $data = array(
        'message' => 'Missing one or more required parameters: city_id, port, value.',
        'error' => true,
    );
}
