<?php

security_check();
application_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    
    // Basic serverside validation
    if (
        !validate_blank($_POST['name']))
    {
        message_set('Application Profile Error', 'There was an error with your application profile information.', 'red');
        header_redirect('/application/profile');
    }

    $query = 'UPDATE applications SET
        name = "'.addslashes($_POST['name']).'"
        WHERE id = '.$_application['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Application Profile Success', 'Your application profile has been updated.');
    header_redirect('/application/dashboard');
    
}

define('APP_NAME', $_application['name']);

define('PAGE_TITLE', 'Application Profile');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/main_header.php');

include('../templates/message.php');

$application = application_fetch($_application['id']);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.faker.ca/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    <?=$_application['name']?>
</h1>
<p>
    <a href="/application/dashboard">Dashboard</a> / 
    Application Profile
</p>
<hr />

<h2>Application Profile</h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="name" 
        class="w3-input w3-border" 
        type="text" 
        id="name" 
        autocomplete="off"
        value="<?=$application['name']?>"
    />
    <label for="name" class="w3-text-gray">
        Name <span id="name-error" class="w3-text-blue"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Profile
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let name = document.getElementById("name");
        let name_error = document.getElementById("name-error");
        name_error.innerHTML = "";
        if (name.value == "") {
            name_error.innerHTML = "(name is required)";
            errors++;
        }

        let width = document.getElementById("width");
        let width_error = document.getElementById("width-error");
        width_error.innerHTML = "";
        if (width.value == "") {
            width_error.innerHTML = "(width is required)";
            errors++;
        }

        let height = document.getElementById("height");
        let height_error = document.getElementById("height-error");
        height_error.innerHTML = "";
        if (height.value == "") {
            height_error.innerHTML = "(height is required)";
            errors++;
        }

        if (errors) return false;
    }

</script>
    
<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
