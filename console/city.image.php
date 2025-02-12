<?php

use \WideImage\WideImage;

security_check();
city_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    
    // Basic serverside validation
    if (
        !validate_image($_FILES['image']))
    {
        message_set('Image Error', 'There was an error with your uploaded image. Image may be wrong type or size.', 'red');
        header_redirect('/city/image');
    }

    $image = Wideimage::load($_FILES['image']['tmp_name']);
    $image = $image->resize(400, 400, 'outside');
    $image = $image->crop('center', 'center', 400, 400);
    $image = 'data:image/jpeg;base64, '.base64_encode($image->asString('jpg'));

    $query = 'UPDATE cities SET
        image = "'.addslashes($image).'"
        WHERE id = '.$_city['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);
    
    message_set('Image Success', 'Your profile image has been updated.');
    header_redirect('/city/dashboard');
    
}

define('APP_NAME', $_city['name']);

define('PAGE_TITLE', 'Image');
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
    <?=$_city['name']?>
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Image
</p>
<hr />

<h2>Image</h2>

<p>Your image image must be a jpg, png, or gif. Images will be resized and cropped to 400 x 400.</p>

<form
    enctype="multipart/form-data"
    method="post"
    novalidate
    id="image-form"
>

    <input  
        name="image" 
        class="w3-input w3-border" 
        type="file" 
        id="image" 
        autocomplete="off"
    />

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Image
    </button>
</form>
    
<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
