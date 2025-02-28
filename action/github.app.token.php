<?php

if(!isset($_GET['code']) || isset($_GET['error']))
{
    message_set('GitHub Error', 'There was an error authenticating your GitHub account.', 'red');
    header_redirect('/login');
}

$token = github_access_token($_GET['code']);
// debug_pre($token);

if(!is_array($token) || !isset($token['access_token']))
{
    message_set('GitHub Error', 'There was an error authenticating your GitHub account.', 'red');
    header_redirect('/login');
}

setting_update('GITHUB_ACCESS_TOKEN', $token['access_token']);

message_set('GitHub Success', 'GitHub account has been connected to the BrickMMO console.');
header_redirect(ENV_CONSOLE_DOMAIN.'/admin/authentication/dashboard');
