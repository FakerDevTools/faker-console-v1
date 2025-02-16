<?php

security_check();
application_check();

define('APP_NAME', $_application['name']);

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/main_header.php');

include('../templates/message.php');

?>

<div class="w3-center">

    <a href="<?=ENV_CONSOLE_DOMAIN?>/application/image">
        <img
            src="<?=application_avatar($_application['id']);?>"
            style="height: 100px"
            class="w3-circle w3-margin-top"
        />
    </a>
    
    <h1 class="w3-margin-top w3-margin-bottom">
        You're working in 
        <?=$_application['name']?>
    </h1>

    <p>Manage your Faker application profile, image, and members.</p>

</div>

<div class="w3-border w3-padding w3-margin-top w3-margin-bottom">

    <div class="w3-margin-top w3-margin-bottom">
        <a href="<?=ENV_CONSOLE_DOMAIN?>/application/profile" class="w3-display-container">
            <i class="fa-solid fa-server fa-padding-right w3-text-dark-grey"></i>
            Application Profile
            <i class="fa-solid fa-chevron-right fa-pull-right w3-text-dark-grey"></i>
        </a>
        <hr>
        <a href="<?=ENV_CONSOLE_DOMAIN?>/application/image" class="w3-block">
            <i class="fa-solid fa-image-portrait fa-padding-right w3-text-dark-grey"></i>
            Image
            <i class="fa-solid fa-chevron-right fa-pull-right w3-text-dark-grey" class="w3-display-right"></i>
        </a>
        <hr>
        <a href="<?=ENV_CONSOLE_DOMAIN?>/application/members" class="w3-block">
            <i class="fa-solid fa-user fa-padding-right w3-text-dark-grey"></i>
            Members
            <i class="fa-solid fa-chevron-right fa-pull-right w3-text-dark-grey" class="w3-display-right"></i>
        </a>
    </div>
</div>

<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
