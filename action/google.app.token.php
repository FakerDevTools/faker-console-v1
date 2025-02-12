<?php

if(!isset($_GET['code']) || isset($_GET['error']))
{
    message_set('Google API Error', 'There was an error authenticating your Google account.', 'red');
    header_redirect('/login');
}

$client = google_get_client();
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

if(!isset($token['access_token']))
{
    message_set('Google API Error', 'There was an error authenticating your Google account.', 'red');
    header_redirect('/login');
}

setting_update('GOOGLE_ACCESS_TOKEN', json_encode($token));

message_set('Google API Success', 'Google account has been connected to the BrickMMO console.');
header_redirect(ENV_CONSOLE_DOMAIN.'/admin/authentication/dashboard');