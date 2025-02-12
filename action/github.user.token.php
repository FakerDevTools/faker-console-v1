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

$emails = github_emails($token['access_token']);
// debug_pre($emails);

if(!is_array($emails) || !count($emails))
{
    message_set('GitHub Error', 'There was an error authenticating your GitHub account.', 'red');
    header_redirect('/login');
}

$github_user = github_user($token['access_token']);

$names = string_split_name($github_user['name']);
$avatar = image_to_bas64($github_user['avatar_url']);

/*
 * Check if logged in user matches GitHub email
 */

if($_user)
{

    $query = 'SELECT *
        FROM users
        WHERE github_username = "'.addslashes($github_user['login']).'"
        AND id != '.$_user['id'].'
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result))
    {
        message_set('GitHub Error', 'The GitHub account '.$github_user['login'].' is already associated to another BrickMMO account.', 'red');
        header_redirect('/account/dashboard');
    }

    foreach($emails as $key => $email)
    {
        if($_user['email'] == $email['email'])
        {
            $email = $email['email'];
            break;
        }
    }

    if(!isset($email))
    {
        message_set('GitHub Error', 'The account you are currently logged in as and the GitHub account do not have matching emails. To resolve this add your BrickMMO email address to your GitHub account. ');
        header_redirect('/account/dashboard');
    }

    $query = 'UPDATE users SET 
        github_username = "'.addslashes($github_user['login']).'",
        github_access_token = "'.addslashes($token['access_token']).'",
        avatar = "'.addslashes($avatar).'"
        WHERE email = "'.$email.'"
        LIMIT 1';
    mysqli_query($connect, $query);

    security_set_user_session($_user['id']);
    security_set_user_cookie($_user['id']);

    message_set('GitHub Success', 'Your GitHub account has been connected to your BrickMMO account.');
    header_redirect('/account/dashboard');

}

/*
 * Check if an existing user has an email associated to this GitHub account.
 */
foreach($emails as $key => $email)
{
    if($user = user_fetch($email['email']))
    {
        break;
    }
}

if($user)
{

    $query = 'SELECT *
        FROM users
        WHERE github_username = "'.addslashes($github_user['login']).'"
        AND id != '.$user['id'].'
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result))
    {
        message_set('GitHub Error', 'There was an error authenticating your GitHub account. The GitHub account '.$github_user['login'].' is already associated to another BrickMMO account.', 'red');
        header_redirect('/register');
    }

    $query = 'UPDATE users SET 
        github_username = "'.addslashes($github_user['login']).'",
        github_access_token = "'.addslashes($token['access_token']).'",
        avatar = "'.addslashes($avatar).'"
        WHERE email = "'.$user['email'].'"
        LIMIT 1';
    mysqli_query($connect, $query);

    security_set_user_session($user['id']);
    security_set_user_cookie($user['id']);

    message_set('GitHub Success', 'You have been logged in using your GitHub account.');
    header_redirect('/account/dashboard');

}

$query = 'SELECT *
    FROM users
    WHERE github_username = "'.addslashes($github_user['login']).'"
    LIMIT 1';
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result))
{
    message_set('GitHub Error', 'There was an error authenticating your GitHub account. The GitHub account '.$github_user['login'].' is already associated to another BrickMMO account.', 'red');
    header_redirect('/register');
}

/*
 * Add a new user.
 */
$query = 'INSERT INTO users (
    first,
    last,
    email,
    github_username,
    github_access_token,
    verify_hash,
    avatar,
    session_id,
    created_at,
    updated_at
) VALUES (
    "'.addslashes($names['first']).'",
    "'.addslashes($names['last']).'",
    "'.addslashes($emails[0]['email']).'",
    "'.addslashes($github_user['login']).'",
    "'.addslashes($token['access_token']).'",
    "'.string_hash().'",
    "'.addslashes($avatar).'",
    "'.string_hash().'",
    NOW(),
    NOW()
)';
mysqli_query($connect, $query);

$user = user_fetch($emails[0]['email']);

ob_start();
include(__DIR__.'/../templates/email_register.php');
$message = ob_get_contents();
ob_end_clean();

email_send($user['email'], user_name($user['id']), $message, 'Email Verification');

security_set_user_session($user['id']);
security_set_user_cookie($user['id']);

message_set('GitHub Success', 'Your BrickMMO account has been created and you have been logged in. You will receive an email with a link to confirm your email address.');
header_redirect('/account/dashboard');
