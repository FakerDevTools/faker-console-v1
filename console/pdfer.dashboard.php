<?php

security_check();
admin_check();

define('APP_NAME', 'Maps');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'pdfer');
define('PAGE_SELECTED_SUB_PAGE', '/pdfer/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

?>


<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <i class="fa-solid fa-file-pdf"></i>
    PDFer
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    PDFer
</p>

<hr>

<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
