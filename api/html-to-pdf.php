<?php

$data = array('test' => 'test');

use Spatie\Browsershot\Browsershot;

// Browsershot::url('https://codeadam.ca')->save('example.pdf');

if(!isset($_GET['url']))
{

    $data = array(
        'message' => 'Missing parameter. API call /html-to-pdf required a URL parameter.',
        'error' => true, 
    );

    return;

}

if(!filter_var($_GET['url'], FILTER_VALIDATE_URL))
{

    $data = array(
        'message' => 'Invalid parameter. API call /html-to-pdf requires a valid URL parameter.',
        'error' => true, 
    );

    return;

}

if(!network_valid($_GET['url']))
{

    $data = array(
        'message' => 'Invalid parameter. API call /html-to-pdf requires a valid URL parameter. URL appears to be unavailble.',
        'error' => true, 
    );

    return;

}

$pdf = Browsershot::url($_GET['url'])
    ->showBackground()
    ->noSandbox()
    ->format('A4')
    ->setNodeBinary('/usr/local/bin/node')
    ->setNpmBinary('/usr/local/bin/npm')
    ->base64pdf();

// header("Content-type:application/pdf");
// header("Content-Disposition:filename=\"codeadam.ca.pdf\"");

$data = array(
    'message' => 'PDF generated successfully.',
    'error' => false, 
    'pdf' => $pdf,
);

