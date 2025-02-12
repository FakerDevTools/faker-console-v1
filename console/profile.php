<?php

$user = user_fetch($_GET['key'], 'url');

if(!$user)
{
    message_set('Profile error', 'This profile does not exist.', 'red');
    include('../404.php');
    die();
}

define('APP_NAME', 'Profile');

define('PAGE_TITLE', $user['url']);

include('../templates/html_header.php');
include('../templates/login_header.php');

?>

<div class="w3-center">

    <h1>BUILDER PROFILE</h1>

    <h2>    
        <?=user_name($user['id'])?>
        <br>
        <a href="https://github.com/<?=$user['github_username']?>">
            <i class="fa-brands fa-github"></i>
            <?=$user['github_username']?>
        </a>
    </h2>

</div>

<?php

include('../templates/login_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
