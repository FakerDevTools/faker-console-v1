<?php

if(security_is_logged_in())
{

    message_set('Login Success', 'You are already logged in.');
    header_redirect(isset($_GET['url']) ? $_GET['url'] : '/account/dashboard');

}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_email($_POST['email']))
    {
        message_set('Forgot Password Error', 'There was an error with your email address.', 'red');
        header_redirect('/forgot');
    }

    if(validate_email_exists($_POST['email'], 'users'))
    {

        $user = user_fetch($_POST['email']);

        $data['reset_hash'] = string_hash();

        $query = 'UPDATE users SET
            reset_hash = "'.$data['reset_hash'].'"
            WHERE email = "'.$_POST['email'].'"
            LIMIT 1';
        mysqli_query($connect, $query);

        ob_start();
        include(__DIR__.'/../templates/email_reset.php');
        $message = ob_get_contents();
        ob_end_clean();

        email_send($user['email'], user_name($user['id']), $message, 'Password Reset');

    }

    message_set('Forgot Password Success', 'If there is an account associated to this email address, you will receive an email message with reset instructions.');
    header_redirect('/login');
    
}

define('APP_NAME', 'My Account');

define('PAGE_TITLE', 'Forgot Password');

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
    
        <input name="email" class="w3-input" type="email" id="email" autocomplete="off" />
        <label for="email" class="w3-text-gray">
            <i class="fa-solid fa-envelope"></i> Email
            <span id="email-error" class="w3-text-red"></span>
        </label>

        <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
            <i class="fa-solid fa-question fa-padding-right"></i>
            Reset Password
        </button>
        
    </form>
    
</div>

<div class="w3-container w3-center w3-margin-top">
    <button
        onclick="location.href='/login';"
        class="w3-button w3-grey w3-text-white"
    >
        <i class="fa-solid fa-caret-left fa-padding-right"></i>
        Back to Login
    </button>
</div>

<script>
    function validateMainForm() {
        let errors = 0;

        let email_pattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$";
        let email = document.getElementById("email");
        let email_error = document.getElementById("email-error");
        email_error.innerHTML = "";
        if (email.value == "") {
          email_error.innerHTML = "(email is required)";
          errors++;
        } else if (!email.value.match(email_pattern)) {
          email_error.innerHTML = "(email is invalid)";
          errors++;
        }

        if (errors) return false;
    }
</script>


<?php

include('../templates/login_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
