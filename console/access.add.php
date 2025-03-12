<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['address']))
    {
        message_set('IP Address Error', 'There was an error with the provided IP address.', 'red');
        header_redirect('/access/add');
    }
    
    $query = 'INSERT INTO ips (
            address,
            status,
            application_id,
            created_at,
            updated_at
        ) VALUES (
            "'.addslashes($_POST['address']).'",
            "allowed",
            "'.$_application['id'].'",
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);

    message_set('IP Address Success', 'Your IP address has been added.');
    header_redirect('/access/dashboard');
    
}

define('APP_NAME', 'ACCESS');

define('PAGE_TITLE', 'Add IP Address');
define('PAGE_SELECTED_SECTION', 'access');
define('PAGE_SELECTED_SUB_PAGE', '/access/add');

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
    IP Address Access
</h1>
<p>
    <a href="/application/dashboard">Dashboard</a> / 
    <a href="/access/dashboard">IP Addresses Access</a> / 
    Add IP Address
</p>

<hr />

<h2>Add IP Address</h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="address" 
        class="w3-input w3-border" 
        type="text" 
        id="address" 
        autocomplete="off"
    />
    <label for="address" class="w3-text-gray">
        IP Address <span id="address-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-tag fa-padding-right"></i>
        Add IP Address
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let address = document.getElementById("address");
        let address_error = document.getElementById("address-error");
        address_error.innerHTML = "";
        if (address.value == "") {
            address_error.innerHTML = "(IP address is required)";
            errors++;
        }
        /*
        // TODO: JavaScript function to validate IP address
        elseif (address.value == "") {
            address_error.innerHTML = "(invalid IP address)";
            errors++;
        }
        */

        if (errors) return false;
    }

</script>
    

<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
