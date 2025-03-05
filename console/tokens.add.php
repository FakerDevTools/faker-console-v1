<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['name']))
    {
        message_set('Token Error', 'There was an error with the provided token.', 'red');
        header_redirect('/tokens/add');
    }
    
    $query = 'INSERT INTO tokens (
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

    message_set('Token Success', 'Your token has been added.');
    header_redirect('/tokens/dashboard');
    
}

define('APP_NAME', 'Tokens');

define('PAGE_TITLE', 'Add Token');
define('PAGE_SELECTED_SECTION', 'tokens');
define('PAGE_SELECTED_SUB_PAGE', '/tokens/add');

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
    Tokens
</h1>
<p>
    <a href="/application/dashboard">Dashboard</a> / 
    <a href="/tokens/dashboard">Tokens</a> / 
    Add Token
</p>

<hr />

<h2>Add Token</h2>

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
        Add Token
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
