<?php

header_not_found();

define('APP_NAME', 'Console');

define('PAGE_TITLE', 'Page Not Found');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('../templates/html_header.php');
include('../templates/login_header.php');  

?>

<div class="w3-center">

    <h1>404 Error</h1>

    <?php include('../templates/message.php'); ?>

    <?php if($_user): ?>
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/action/logout">Logout</a> | 
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/account/dashboard">Account Dashboard</a> | 
        <a href="<?=ENV_CONSOLE_DOMAIN?>/city/dashboard">City Dashboard</a>
    <?php else: ?>
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/login">Login</a> | 
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/register">Register</a>
    <?php endif; ?>
    

</div>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
