<?php

header_not_found();

define('APP_NAME', 'Error');

define('PAGE_TITLE', 'Page Not Found');

include('templates/html_header.php');
include('templates/login_header.php');  

?>

<h1>404 Error</h1>

<?php include('templates/message.php'); ?>

<a href="/action/logout">Logout</a> | 
<a href="/login">Login</a> | 
<a href="/city/dashboard">Dashboard</a>

<?php

include('templates/debug.php');

include('templates/login_footer.php');
include('templates/html_footer.php');
