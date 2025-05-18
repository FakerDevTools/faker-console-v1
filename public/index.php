<?php

/**
 * All URLs that do not match an existing file are routed to this page via the 
 * .htaccss file. This files splits the URL into a variety of components to 
 * determine which PHP file to execute and which parts of the URL are variables. 
 * 
 * For example:
 * http://local.console.faker.ca:7777/media/tags/edit/1
 * Will route to the /console/media.tags.php file with a variable named edit
 * with a value of 1.
 */

/**
 * Load libraries through composer.
 */
require __DIR__ . '/../vendor/autoload.php';

/**
 * Include database connecton, session initialiation, and function
 * files.
 */
include('../includes/connect.php');
include('../includes/session.php');
include('../includes/config.php');
include('../functions/functions.php');

/**
 * Fetch application and user if applicable.
 */ 
if(isset($_SESSION['user'])) $_user = user_fetch($_SESSION['user']['id']);
else $_user = false;

if(isset($_SESSION['application'])) $_application = application_fetch($_SESSION['application']['id']);
else $_application = false;

/**
 * Get domain.
 */
if(is_numeric(strpos($_SERVER['HTTP_HOST'], 'account'))) $domain = 'account';
elseif(is_numeric(strpos($_SERVER['HTTP_HOST'], 'console'))) $domain = 'console';
elseif(is_numeric(strpos($_SERVER['HTTP_HOST'], 'api'))) $domain = 'api';
else
{

    include('404.php');
    exit;
    
}

/**
 * Convert standard format URL parameters to slashes.
 */ 
if(strpos($_SERVER['REQUEST_URI'], '?'))
{

    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    $url[1] = str_replace(array('/', '%2F'), urlencode('-SLASH-'), $url[1]);
    $url[1] = str_replace(array('?','=', '&'), '/', $url[1]);
    $url = implode('/', $url);
    debug_pre($url);
    header_redirect($url);

}

/**
 * Split URL infor array.
 */ 
$parts = array_filter(explode("/", trim($_SERVER['REQUEST_URI'], "/")));

/**
 * If there are no parts, redirect to login page.
 */
if(!count($parts))
{

    header_redirect(ENV_CONSOLE_DOMAIN.'/application/dashboard');

}

/**
 * If the request is an ajax request. 
 */
if($parts[0] == 'ajax')
{

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    header('Content-Type: application/json; charset=utf-8');

    define('PAGE_TYPE', 'ajax');
    array_shift($parts);
    $folder = 'ajax/';

}

/**
 * If the request is a action request. 
 */
elseif($parts[0] == 'action')
{

    define('PAGE_TYPE', 'action');
    array_shift($parts);
    $folder = 'action/';

}

/**
 * If the request is an API request. 
 */
elseif($domain == 'api')
{

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    header('Content-Type: application/json; charset=utf-8');

    define('PAGE_TYPE', 'api');
    $folder = 'api/';

}

/**
 * If the request is a standard web request. 
 */
else
{

    define('PAGE_TYPE', 'web');
    $folder = $domain;
    
}

/**
 * Parse URL for possible filenames and check if file exists. 
 */
$file = '';
$final_file = '';

foreach($parts as $part)
{
    
    $file = str_replace('php', '', $file);
    $file .= array_shift($parts).'.php';

    if(file_exists('../'.$folder.'/'.$file)) 
    {
        $final_file = $file;
        $final_parts = $parts;
    }

}

if($final_file) define('PAGE_FILE', $final_file);

/**
 * If URL does not result in an existing file. 
 */
if(!defined('PAGE_FILE'))
{

    if(PAGE_TYPE == 'api')
    {

        $data = array(
            'message' => 'API URL is invalid.',
            'error' => true, 
        );

        api_call(false, false, 'url');

        echo json_encode($data);

    }
    else
    {
        include('404.php');        
    }

    exit;

}

/**
 * Parse remaining URL data into a $_GET array. 
 */

 /**
  * If there is only one part, the value is placed into the $_GET array with the
  * key set to "key". 
  */
if(count($final_parts) == 1)
{

    $_GET['key'] = array_shift($final_parts);

}

/**
 * If there are an odd number of parts, the final part is placed into the $_GET array 
 * with the key set to "key". 
 */
elseif(count($final_parts) % 2 == 1)
{

    $_GET['key'] = array_pop($final_parts);
    /*
    while($next = array_shift($final_parts))
    {
        if($next) $_GET['key'] = $next;
    }
    */
    
}

/**
 * Remaining parts are placed into the $_GET array using alternating parts as keys
 * and values.
 */
for($i = 0; $i < count($final_parts); $i += 2)
{

    /**
     * Slashed return from the Google API were breaking the .htaccess, so slashes in 
     * the URL paramaters are replaced with "-SLASH-" and switched back to slashes 
     * below. There must be a better solution to this, but this works for now. 
     */
    $_GET[$final_parts[$i]] = isset($final_parts[$i+1]) ? 
        urldecode(str_replace('-SLASH-', '/', $final_parts[$i+1])) : 
        true;

}

/**
 * If the request is an ajax request. 
 */
if(PAGE_TYPE == 'ajax') 
{

    $_POST = json_decode(file_get_contents('php://input'), true);
    include('../ajax/'.PAGE_FILE);
    echo json_encode($data);
    exit;
    
}

/**
 * If the request is an API request. 
 */
elseif(PAGE_TYPE == 'api') 
{

    // Check for a missing key
    if(!isset($_GET['key']))
    {

        $data = array(
            'message' => 'API key error. API key is missing.',
            'error' => true, 
        );

        api_call(false, false, 'url');

        echo json_encode($data);
        exit;

    }
    else
    {

        $_key = api_check_key();

        if(!$_key)
        {

            $data = array(
                'message' => 'API key error. API key '.$_GET['key'].' does not exist.',
                'error' => true, 
            );

            api_call($_GET['key'], false, 'key');

            echo json_encode($data);
            exit;

        }

        $_application = application_fetch($_key['application_id']);

        $_ip_address = api_check_ip_address();

        /*
        debug_pre($_ip_address);
        debug_pre($_key);
        */

        if($_ip_address['status'] == 'pending' && $_ip_address['filtering'] == true)
        {
            
            $data = array(
                'message' => 'IP address error. IP address '.$_ip_address['address'].' is currently set to pending. Login to your console and approve IP address.',
                'error' => true, 
            );

            api_call($_key['ip'], $_ip_address['id'], 'key');

            echo json_encode($data);
            exit;

        }
        elseif($_ip_address['status'] == 'blocked' && $_ip_address['filtering'] == true)
        {

            $data = array(
                'message' => 'IP address error. IP address '.$_ip_address['address'].' is currently set to blocked. Login to your console and approve IP address.',
                'error' => true, 
            );

            api_call($_key['ip'], $_ip_address['id'], 'key');

            echo json_encode($data);
            exit;

        }

    }

    api_call($_key['id'], $_ip_address['id'], 'success');

    include('../api/'.PAGE_FILE);

    echo json_encode($data);
    exit;

}

/**
 * If the request is an action request. 
 */
elseif(PAGE_TYPE == 'action') 
{

    include('../action/'.PAGE_FILE);
    exit;

}

/**
 * If the request is a standard web request. 
 */
else
{

    include('../'.$folder.'/'.PAGE_FILE);

}

