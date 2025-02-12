<?php
global $connect;
$current_time = date('Y-m-d H:i:s');
$query = "SELECT content FROM `broadcast_logs` WHERE broadcast_time <= '$current_time'";

$result = mysqli_query($connect, $query);

$logs = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Fetch only the 'content' field and remove newline characters
    $logs[] = str_replace("\n", '', $row['content']);
}

$curl = curl_init();
$postData = array(
    'text' => implode(" ", $logs)  // Combine all logs into a single string
);

$postData['text'] = substr($postData['text'], 0, strrpos(substr($postData['text'], 0, 1950), ' '));

// Now, remove any escaped Unicode characters like \u2019
$postData['text'] = preg_replace('/\\\\u[0-9a-fA-F]{4}/', '', $postData['text']);

// Remove all backslashes, asterisks, and double quotes
$postData['text'] = str_replace(["\\", "*", "\""], "", $postData['text']);


$data = $postData;
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.deepgram.com/v1/speak?model=aura-helios-en",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $postData['text'],
    CURLOPT_HTTPHEADER => array(
        "Authorization: Token " . DEEPGRAM_API_KEY,
        "Content-Type: text/plain"
    ),
));
$response = curl_exec($curl);
$data = $response;
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
    $data = array(
        'message' => 'Error Processing speech',
        'error' => true,
    );
} else {
    $data = $response;
    // Set headers to treat response as a blob if needed
    header('Content-Type: audio/mpeg');
    echo $data;
}
