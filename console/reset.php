<?php

if(security_is_logged_in())
{

    message_set('Already Logged In', 'You are currently logged in.');
    header_redirect(isset($_GET['url']) ? $_GET['url'] : '/account/dashboard');

}
elseif(!user_fetch($_GET['hash']))
{

    message_set('Password Reset Error', 'There was an error with the password reset link, please try again.', 'red');
    header_redirect('/forgot');
    
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_password($_POST['password']))
    {
        message_set('Password Reset Error', 'There was an error with your password.', 'red');
        header_redirect('/reset/hash/'.$_GET['hash']);
    }

    $query = 'UPDATE users SET
        password = "'.password_hash(addslashes($_POST['password']), PASSWORD_BCRYPT).'"
        WHERE reset_hash = "'.addslashes($_GET['hash']).'"
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Password Reset Success', 'Your password has been reset. Please login using your new password.');
    header_redirect('/login');
    
}

define('APP_NAME', 'My Account');

define('PAGE_TITLE', 'Reset Password');

include('../templates/html_header.php');
include('../templates/login_header.php');

?>

<?php include('../templates/message.php'); ?>


<div>
    <form
        method="post"
        novalidate
        id="main-form"
    >

        <input name="password" class="w3-input" type="password" id="password" autocomplete="off" />
        <label for="password" class="w3-text-gray">
            <i class="fa-solid fa-lock"></i> New Password
            <span id="password-error" class="w3-text-red"></span>
        </label>

        <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
            <i class="fa-solid fa-question fa-padding-right"></i>
            Reset Password
        </button>

    </form>
</div>

<div class="w3-container w3-center w3-margin">
    <button
        onclick="location.href='/reset/hash/<?=$_GET['hash']?>';"
        class="w3-button w3-grey w3-text-white"
    >
        <i class="fa-solid fa-caret-left fa-padding-right"></i>
        Back to Login
    </button>
</div>

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

        if (errors) return false;
    }
</script>


<?php

include('../templates/login_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
