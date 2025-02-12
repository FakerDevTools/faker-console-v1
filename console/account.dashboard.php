<?php

security_check();

if(isset($_SESSION['invite']))
{

    $invite = invite_fetch($_SESSION['invite']);

    $query = 'SELECT *
        FROM city_user
        WHERE user_id = '.$_user['id'].'
        AND city_id = '.$invite['city_id'].'
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result))
    {
        unset($_SESSION['invite']);

        message_set('Invitation Error', 'You are already a member of this city.', 'red', true);
        header_redirect('/account/dashboard');
    }

    $query = 'INSERT INTO city_user (
            city_id,
            user_id
        ) VALUES (
            '.$invite['city_id'].',
            '.$_user['id'].'
        )';
    mysqli_query($connect, $query); 

    unset($_SESSION['invite']);

    message_set('Invitation Success', 'Invitation to the new city has been accepted!', 'green', true);
    header_redirect(ENV_CONSOLE_DOMAIN.'/action/city/select/id/'.$invite['city_id']);

}

if(isset($_GET['key']) && $_GET['key'] == 'verify')
{

    $data['verify_hash'] = string_hash();

    $query = 'UPDATE users SET
        verify_hash = "'.$data['verify_hash'].'"
        WHERE id = "'.$_user['id'].'"
        LIMIT 1';
    mysqli_query($connect, $query);

    ob_start();
    include(__DIR__.'/../templates/email_register.php');
    $message = ob_get_contents();
    ob_end_clean(); 

    email_send($_user['email'], user_name($_user['id']), $message, 'Email Verification');

    message_set('Verification Success', 'A verification email has been resent.');
    header_redirect('/account/dashboard');

}

define('APP_NAME', 'My Account');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/main_header.php');

?>

<?php include('../templates/message.php'); ?>

<div class="w3-center">

    <a href="<?=ENV_ACCOUNT_DOMAIN?>/account/avatar">
        <img
            src="<?=user_avatar($_user['id']);?>"
            style="height: 100px"
            class="w3-circle w3-margin-top"
        />
    </a>
    
    <h1 class="w3-margin-top w3-margin-bottom">
        Welcome, 
        <?=user_name($_user['id'])?>
    </h1>

    <p>Manage your BrickMMO profile, avatar, and GitHub connection.</p>

</div>

    <?php if(!$_user['email_verified_at']): ?>
        <div class="w3-border w3-padding w3-margin-top w3-margin-bottom w3-light-grey">
            <h3>
                <i class="fa-solid fa-envelope"></i>
                Email Unverified
            </h3>
            <p>Verify your email address to unlock all BrickMMO console features.</p>
            <a href="/account/dashboard/verify" class="w3-button w3-white w3-border">
                <i class="fa-solid fa-arrow-rotate-right fa-padding-right"></i> Resend Verification Email
            </a>
        </div>
    <?php endif; ?>

<div class="w3-border w3-padding w3-margin-top w3-margin-bottom">

    <div class="w3-margin-top w3-margin-bottom">
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/account/profile" class="w3-display-container">
            <i class="fa-solid fa-user fa-padding-right w3-text-dark-grey"></i>
            My Profile
            <i class="fa-solid fa-chevron-right fa-pull-right w3-text-dark-grey"></i>
        </a>
        <hr>
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/account/url" class="w3-block">
            <i class="fa-solid fa-globe fa-padding-right w3-text-dark-grey"></i>
            URL
            <i class="fa-solid fa-chevron-right fa-pull-right w3-text-dark-grey" class="w3-display-right"></i>
        </a>
        <hr>
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/account/avatar" class="w3-block">
            <i class="fa-solid fa-image-portrait fa-padding-right w3-text-dark-grey"></i>
            Avatar
            <i class="fa-solid fa-chevron-right fa-pull-right w3-text-dark-grey" class="w3-display-right"></i>
        </a>
        <hr>
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/account/password" class="w3-block">
            <i class="fa-solid fa-lock fa-padding-right w3-text-dark-grey"></i>
            Change Password
            <i class="fa-solid fa-chevron-right fa-pull-right w3-text-dark-grey" class="w3-display-right"></i>
        </a>
        <hr>
        <a href="<?=ENV_ACCOUNT_DOMAIN?>/account/github" class="w3-block">
            <i class="fa-brands fa-github fa-padding-right w3-text-dark-grey"></i>
            GitHub Account
            <?php if($_user['github_username']): ?>(<?=$_user['github_username']?>)<?php endif; ?>
            <i class="fa-solid fa-chevron-right fa-pull-right w3-text-dark-grey" class="w3-display-right"></i>
        </a>
    </div>
</div>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
