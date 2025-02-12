<?php

// Check if all required GET parameters are present
if (isset($_GET['city']) && isset($_GET['port'])) {

    // Escape and validate the input to prevent SQL injection
    $city_id = intval($_GET['city']);
    $port = mysqli_real_escape_string($connect, $_GET['port']);    

    // Check if 'cartridge' is present and handle NULL values
    $cartridge = isset($_GET['cartridge']) ? mysqli_real_escape_string($connect, $_GET['cartridge']) : null;

    // Build the query to update the panel data, considering whether cartridge is NULL
    $query = "
        SELECT *
        FROM panels
        WHERE city_id = $city_id 
          AND port = '$port' 
          AND " . ($cartridge === null ? "cartridge IS NULL" : "cartridge = '$cartridge'");

    // Execute the query
    $result = mysqli_query($connect, $query);

    // Initialize response array
    $data = mysqli_fetch_assoc($result);
    
} else {
    // Handle the case where one or more required parameters are missing in the request
    $data = array(
        'message' => 'Missing one or more required parameters: city_id, port, value.',
        'error' => true,
    );
}
