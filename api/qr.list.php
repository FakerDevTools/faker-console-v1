<?php

$query = 'SELECT qrs.*,(
        SELECT COUNT(*)
        FROM qr_logs
        WHERE qrs.id = qr_logs.qr_id
    ) AS scans
    FROM qrs    
    ORDER BY name';
$result = mysqli_query($connect, $query);

$qrs = [];

while($record = mysqli_fetch_assoc($result)) 
{
    $qrs[] = $record;
}

$data = array(
    'message' => 'QR codes retrieved successfully.',
    'error' => false, 
    'qrs' => $qrs,
);