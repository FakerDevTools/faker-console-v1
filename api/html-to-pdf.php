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
    ->setNodeBinary('/usr/local/bin/node')
    ->setNpmBinary('/usr/local/bin/npm');

if(isset($_GET['size']))
{

    if(!in_array($_GET['size'], pdf_sizes()))
    {

        $data = array(
            'message' => 'Invalid parameter. API call /html-to-pdf requires a valid size parameter. Size appears to be invalid.',
            'error' => true,
        );

        return;

    }
    else
    {
        $pdf->format($_GET['size']);
    }

}
elseif(isset($_GET['width']) && isset($_GET['height']))
{

    if(!is_numeric($_GET['width']) || !is_numeric($_GET['height']) || $_GET['width'] <= 0 || $_GET['height'] <= 0)
    {

        $data = array(
            'message' => 'Invalid parameter. API call /html-to-pdf requires a valid width and height parameter. Width and height do not appears to be valid.',
            'error' => true,
        );

        return;

    }
    else
    {
        
        $pdf->paperSize($_GET['width'], $_GET['height']);

    }


}
else
{

    $data = array(
        'message' => 'Invalid parameter. API call /html-to-pdf requires a valid size or width and height parameter. Neither appear to be provided.',
        'error' => true,
    );

    return;

}



// header("Content-type:application/pdf");
// header("Content-Disposition:filename=\"codeadam.ca.pdf\"");

$data = array(
    'message' => 'PDF generated successfully.',
    'error' => false, 
    'pdf' => $pdf->base64pdf(),
);
