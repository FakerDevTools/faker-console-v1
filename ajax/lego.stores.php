<?php

// TODO
// If not logged in
// Check for key

if(!security_is_logged_in())
{
    $data = array('message' => 'Must be logged in to use this ajax call.', 'error' => false);
    return;
}

$url = 'https://www.lego.com/api/graphql/StoresDirectory';

$query = '
query {
  storesDirectory {
    id
    country
    region
    stores {
      storeId
      name
      phone
      state
      phone
      openingDate
      certified
      additionalInfo
      storeUrl
      urlKey
      isNewStore
      isComingSoon
      __typename
    }
    __typename
  }
}';

$data = array('query' => $query);
$jsonData = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    $stores = json_decode($response, true);   
}

curl_close($ch);

$query = 'TRUNCATE TABLE stores';
mysqli_query($connect, $query);

$query = 'UPDATE settings SET 
  value = NOW() 
  WHERE name = "STORES_LAST_IMPORT" 
  LIMIT 1';
mysqli_query($connect, $query);

$data = array(
    'message' => 'LEGO Stores has been retrieved.',
    'error' => false, 
    'stores' => $stores
);
