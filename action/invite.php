<?php

if(!isset($_GET['hash']) || !invite_fetch($_GET['hash']))
{
    message_set('City Invite Error', 'There was an error with the password reset link, please try again.', 'red');
    header_redirect(ENV_ACCOUNT_DOMAIN.'/login');
}

$_SESSION['invite'] = $_GET['hash'];

if($_user)
{
    header_redirect(ENV_ACCOUNT_DOMAIN.'/account/dashboard');
}

message_set('City Invite Success', 'You have been invited to join a city, please login or register to accept invitation.');
header_redirect(ENV_ACCOUNT_DOMAIN.'/login');
