<?php

use \WideImage\WideImage;

security_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    
    // Basic serverside validation
    if (
        !validate_image($_FILES['avatar']))
    {
        message_set('Avatar Upload Error', 'There was an error with your uploaded image.', 'red');
        header_redirect('/account/avatar');
    }

    $image = Wideimage::load($_FILES['avatar']['tmp_name']);
    $image = $image->resize(400, 400, 'outside');
    $image = $image->crop('center', 'center', 400, 400);
    $image = 'data:image/jpeg;base64, '.base64_encode($image->asString('jpg'));

    $query = 'UPDATE users SET
        avatar = "'.addslashes($image).'"
        WHERE id = '.$_user['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    // Start session and store user data
    security_set_user_session($_user['id']);
    
    message_set('Avatar Upload Success', 'Your avatar has been updated.');
    header_redirect('/account/dashboard');
    
}

define('APP_NAME', 'My Account');

define('PAGE_TITLE', 'Avatar');
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
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    My Account
</h1>
<p>
    <a href="/account/dashboard">Dashboard</a> / 
    Avatar
</p>
<hr />

<h2>Avatar</h2>

<p>Your profile image must be a jpg, png, or gif. Images will be resized and cropped to 400 x 400.</p>

<form
    enctype="multipart/form-data"
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="avatar" 
        class="w3-input w3-border" 
        type="file" 
        id="avatar" 
        autocomplete="off"
    />

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Avatar
    </button>
</form>
    
<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
