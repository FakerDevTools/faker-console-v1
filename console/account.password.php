<?php

security_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_blank($_POST['password']) || 
        !validate_blank($_POST['password_confirm']) || 
        $_POST['password'] != $_POST['password_confirm'])
    {
        message_set('Password Error', 'There was an error with your new password.', 'red');
        header_redirect('/account/password');
    }

    $query = 'UPDATE users SET
        password = "'.addslashes(password_hash($_POST['password'], PASSWORD_BCRYPT)).'"
        WHERE id = '.$_user['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    // Start session and store user data
    security_set_user_session($_user['id']);

    // Set cookie
    security_set_user_cookie($_user['id']);
    
    message_set('Password Success', 'Your password has been updated.');
    header_redirect('/account/dashboard');
    
}

define('APP_NAME', 'My Account');

define('PAGE_TITLE', 'Change Password');
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
    Change Password
</p>
<hr />

<h2>Change Password</h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="password" 
        class="w3-input w3-border" 
        type="password" 
        id="password" 
        autocomplete="off"
    />
    <label for="password" class="w3-text-gray">
        <i class="fa-solid fa-lock"></i>
        Password <span id="password-error" class="w3-text-red"></span>
    </label>

    <input 
        name="password_confirm" 
        class="w3-input w3-margin-top w3-border" 
        type="password" 
        id="password-confirm" 
        autocomplete="off"
    />
    <label for="password-confirm" class="w3-text-gray">
        <i class="fa-solid fa-lock"></i>
        Confirm Password <span id="password-confirm-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Password
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let password = document.getElementById("password");
        let password_error = document.getElementById("password-error");
        password_error.innerHTML = "";
        if (password.value == "") {
            password_error.innerHTML = "(password is required)";
            errors++;
        }
        else if (password.value.length < 8) {
            password_error.innerHTML = "(password must be at least 8 characters)";
            errors++;
        }

        let password_confirm = document.getElementById("password-confirm");
        let password_confirm_error = document.getElementById("password-confirm-error");
        password_confirm_error.innerHTML = "";
        if (password_confirm.value == "") {
            password_confirm_error.innerHTML = "(password confirm is required)";
            errors++;
        }
        else if (password.value != password_confirm.value) {
            password_confirm_error.innerHTML = "(password confirm must match password)";
            errors++;
        }

        if (errors) return false;
    }

</script>
    
<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
