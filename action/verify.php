<?php

if(!isset($_GET['hash']) || !user_fetch($_GET['hash']))
{
    message_set('Verification Error', 'There was an error with the password reset link, please try again.', 'red');
    header_redirect('/forgot');
}
else
{

    $user = user_fetch($_GET['hash']);
    
    $query = 'UPDATE users SET
        email_verified_at = NOW()
        WHERE verify_hash = "'.addslashes($_GET['hash']).'"
        AND email_verified_at IS NULL
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Verification Success', 'Your email address has been verified.');
    header_redirect('/login');
    
}
