<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['name']))
    {
        message_set('Key Error', 'There was an error with the provided key.', 'red');
        header_redirect('/keys/add');
    }
    
    $query = 'INSERT INTO keys (
            name,
            hash,
            application_id,
            created_at,
            updated_at
        ) VALUES (
            "'.addslashes($_POST['name']).'",
            "'.addslashes(string_hash(20, 'alphanumeric')).'",
            "'.$_application['id'].'",
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);

    message_set('KEy Success', 'Your key has been added.');
    header_redirect('/keys/dashboard');
    
}

define('APP_NAME', 'Keys');

define('PAGE_TITLE', 'Add Key');
define('PAGE_SELECTED_SECTION', 'keys');
define('PAGE_SELECTED_SUB_PAGE', '/keys/add');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <i class="fa-solid fa-key"></i>
    Keys
</h1>
<p>
    <a href="/application/dashboard">Dashboard</a> / 
    <a href="/keys/dashboard">keys</a> / 
    Add Key
</p>

<hr />

<h2>Add Key</h2>

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
    />
    <label for="name" class="w3-text-gray">
        Name <span id="name-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-tag fa-padding-right"></i>
        Add Key
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

        if (errors) return false;
    }

</script>
    

<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
