<?php

if(!isset($_GET['key']) || !is_numeric($_GET['key']))
{
    $data = array(
        'message' => 'Invalid QR hash.',
        'error' => true,
        'qr' => '',
    );

    return;
}


$query = 'SELECT *
    FROM qrs 
    WHERE hash = "'.$_GET['key'].'"
    LIMIT 1';
$result = mysqli_query($connect, $query);

if(!mysqli_num_rows($result))
{
    $data = array(
        'message' => 'QR code not found.',
        'error' => true,
        'qr' => '',
    );

    return;
}

$qr = mysqli_fetch_aSSOC($result);

$data = array(
    'message' => 'QR code retrieved successfully.',
    'error' => false,
    'qr' => $qr,
);

$query = 'INSERT INTO qr_logs (
        name,
        hash,
        url,
        qr_id,
        created_at,
        updated_at
    ) VALUES (
        "'.$qr['name'].'",
        "'.$qr['hash'].'",
        "'.$qr['url'].'",
        "'.$qr['id'].'",
        NOW(),
        NOW()
    )';
mysqli_query($connect, $query);
