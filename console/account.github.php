<?php

security_check();

define('APP_NAME', 'My Account');

define('PAGE_TITLE', 'GitHub Account');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/main_header.php');

include('../templates/message.php');

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.faker.ca/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    My Account
</h1>
<p>
    <a href="/account/dashboard">Dashboard</a> / 
    GitHub Account
</p>
<hr />
<h2>GitHub Account</h2>

<?php if($_user['github_username']): ?>

    <p>
        Your Faker account is currently connected to your 
        <a href="https://github.com/<?=$_user['github_username']?>">
            <i class="fa-brands fa-github"></i>
            <?=$_user['github_username']?>
        </a> 
        GitHub account.
    </p>

    <hr>

    <p>Revoking GitHub acccess from your Faker account will:</p>
    <ul class="w3-ul w3-margin-bottom">
        <li>Remove all GitHub access from your Faker account.</li>
        <li>
            Disable your Faker 
            <a href="<?=ENV_CONSOLE_DOMAIN?>/profile/<?=$_user['github_username']?>/">public profile</a>.
        </li>
        <li>Prevent retrieving of Faker contribution stats.</li>
        <li>Not remove your GitHub avatar from your Faker account.</li>
    </ul>
    <a href="<?=ENV_CONSOLE_DOMAIN?>/action/github/user/revoke" class="w3-button w3-white w3-border">
        <i class="fa-solid fa-xmark fa-padding-right"></i>
        Revoke GitHub Account Access
    </a>

<?php else: ?>

    <p>
        Your Faker account is currently <strong>NOT</strong> connected to your GitHub account.
    </p>

    <hr>

    <p>Providing GitHub acccess from your Faker account will:</p>
    <ul class="w3-ul w3-margin-bottom">
        <li>
            Enable your Faker public profile.
        </li>
        <li>Permit retrieving of Faker contribution stats.</li>
        <li>Apply your GitHub avatar to your Faker account.</li>
    </ul>
    <a href="<?=github_url()?>" class="w3-button w3-white w3-border">
        <i class="fa-solid fa-plus fa-padding-right"></i>
        Connect my GitHub Account
    </a>

<?php endif; ?>


    
<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
