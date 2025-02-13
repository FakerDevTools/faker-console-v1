<?php

function security_is_logged_in()
{

    if(isset($_COOKIE['hash_id']) && isset($_COOKIE['hash_string']))
    {

        $id = security_decrypt($_COOKIE['hash_id']);
        $user = user_fetch($id);

        if(!$user) return false;
        else if($user['password'] != security_decrypt($_COOKIE['hash_string'])) return false;

        if(!isset($_SESSION['user']))
        {
            security_set_user_session($id);
            header_redirect($_SERVER["REQUEST_URI"]);
        }

        security_extend_cookie();

    }
    else
    {
        return false;
    }

    if(isset($_SESSION['user']) && isset($_SESSION['user']['id']))
    {

        if(isset($_SESSION['user']['session_id']))
        {

            $user = user_fetch($_SESSION['user']['id']);

            if(password_verify($user['session_id'], $_SESSION['user']['session_id']))
            {
                return true;
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;     
        }
    }
    else
    {
        return false;
    }

}

function security_extend_cookie()
{

    setcookie('hash_id', $_COOKIE['hash_id'], time() + (60 * 60 * 24 * 30), '/', 'faker.ca');
    setcookie('hash_string', $_COOKIE['hash_string'], time() + (60 * 60 * 24 * 30), '/', 'faker.ca');

}

function security_set_user_cookie($id)
{
    
    $user = user_fetch($id);

    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    setcookie('hash_id', security_encrypt($user['id']), time() + (60 * 60 * 24 * 30), '/', 'faker.ca');
    setcookie('hash_string', security_encrypt($user['password']), time() + (60 * 60 * 24 * 30), '/', 'faker.ca');

}

function security_set_user_session($id)
{

    $user = user_fetch($id);

    $_SESSION['user']['id'] = $user['id'];
    $_SESSION['user']['first'] = $user['first'];
    $_SESSION['user']['last'] = $user['last'];
    $_SESSION['user']['admin'] = $user['admin'];
    $_SESSION['user']['session_id'] = password_hash($user['session_id'], PASSWORD_BCRYPT);
    $_SESSION['user']['github_username'] = $user['github_username'];
    $_SESSION['user']['avatar'] = $user['avatar'];
    $_SESSION['user']['application_id'] = $user['application_id'];

    if($application = application_fetch($user['application_id']))
    {
        $_SESSION['application']['id'] = $application['id'];
        $_SESSION['application']['name'] = $application['name'];
        $_SESSION['application']['image'] = $application['image'];
    }

}

function security_check()
{

    if(!security_is_logged_in())
    {
        header_redirect(ENV_ACCOUNT_DOMAIN.'/login');
    }

    $id = security_decrypt($_COOKIE['hash_id']);

    security_set_user_session($id);

}

function security_encrypt($data)
{

    // Define the secret key
    $key = ENV_SALT;

    // Define the encryption method
    $method = "AES-256-CBC";

    // Generate a random initialization vector (IV)
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

    // Encrypt the data
    $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);

    // Concatenate the IV and the encrypted data
    $encrypted = base64_encode($iv.$encrypted);

    return $encrypted;

}

function security_decrypt($encrypted)
{

    // Define the secret key
    $key = ENV_SALT;

    // Define the encryption method
    $method = "AES-256-CBC";

    // Decode the encrypted data
    $encrypted = base64_decode($encrypted);

    // Extract the IV and the encrypted data
    $iv = substr($encrypted, 0, openssl_cipher_iv_length($method));
    $encrypted = substr($encrypted, openssl_cipher_iv_length($method));

    // Decrypt the data
    $decrypted = openssl_decrypt($encrypted, $method, $key, 0, $iv);

    // Display the decrypted data
    return $decrypted;

}