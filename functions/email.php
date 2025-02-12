<?php

use \SendGrid\Mail\Mail;

function email_send(
    $to_email,
    $to_name,
    $message,
    $subject
)
{

    /*
    echo 'From Name: '.SENDGRID_FROM_NAME.'<br>';
    echo 'From Email: '.SENDGRID_FROM_EMAIL.'<br>';
    echo 'From Name: '.SENDGRID_FROM_NAME.'<br>';
    echo 'From Email: '.SENDGRID_FROM_EMAIL.'<br>';
    */

    $email = new Mail();
    $email->setFrom(SENDGRID_FROM_EMAIL, SENDGRID_FROM_NAME);
    $email->setSubject($subject);
    $email->addTo($to_email, $to_name);
    $email->addContent("text/html", $message);
    
    $sendgrid = new \SendGrid(SENDGRID_API_KEY);

    try {
        
        $response = $sendgrid->send($email);

        unset($_SESSION['email']);

        $_SESSION['email'] = array(
            'status_code' => $response->statusCode(),
            'headers' => $response->headers(),
        );

    } catch (Exception $e) {

        /*
        echo 'Caught exception: '.  $e->getMessage(). "\n";
        */

    }
    
}
