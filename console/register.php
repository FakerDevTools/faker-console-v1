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
        !validate_email($_POST['email']) || 
        !validate_password($_POST['password']) || 
        !validate_blank($_POST['first']) || 
        !validate_blank($_POST['last']) || 
        validate_email_exists($_POST['email'], 'users'))
    {
        message_set('Registration Error', 'There was an error with your registration information.', 'red');
        header_redirect('/register');
    }

    $query = 'INSERT INTO users (
            first,
            last,
            email,
            password,
            session_id,
            created_at,
            updated_at
        ) VALUES (
            "'.addslashes($_POST['first']).'",
            "'.addslashes($_POST['last']).'",
            "'.addslashes($_POST['email']).'",
            "'.addslashes(password_hash($_POST['password'], PASSWORD_BCRYPT)).'",
            "'.string_hash().'",
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);

    $user = user_fetch($_POST['email']);

    $data['verify_hash'] = string_hash();

    $query = 'UPDATE users SET
        verify_hash = "'.$data['verify_hash'].'"
        WHERE email = "'.$_POST['email'].'"
        LIMIT 1';
    mysqli_query($connect, $query);

    ob_start();
    include(__DIR__.'/../templates/email_register.php');
    $message = ob_get_contents();
    ob_end_clean();

    email_send($user['email'], user_name($user['id']), $message, 'Email Verification');

    message_set('Registraton Success', 'Your account has been created. Please confirm your email address and then login.');
    header_redirect('/login');
    
}

define('APP_NAME', 'My Account');

define('PAGE_TITLE', 'Register');

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

        <input 
            name="first" 
            class="w3-input" 
            type="text" 
            id="first" 
            autocomplete="off"
        />
        <label for="first" class="w3-text-gray">
            First Name <span id="first-error" class="w3-text-red"></span>
        </label>

        <input 
            name="last" 
            class="w3-input" 
            type="text" 
            id="last" 
            autocomplete="off"
        />
        <label for="last" class="w3-text-gray">
            Last Name <span id="last-error" class="w3-text-red"></span>
        </label>

        <input 
            name="email" 
            class="w3-input" 
            type="email" 
            id="email" 
            autocomplete="off" 
        />  
        <label for="email" class="w3-text-gray">
            <i class="fa-solid fa-envelope"></i>
            Email <span id="email-error" class="w3-text-red"></span>
        </label>

        <input
            name="password" 
            class="w3-input"
            type="password"
            id="password"
            autocomplete="off"
        />
        <label for="password" class="w3-text-gray">
            <i class="fa-solid fa-lock"></i>
            Password <span id="password-error" class="w3-text-red"></span>
        </label>

        <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="validateMainForm(); return false;">
            <i class="fa-solid fa-pen fa-padding-right"></i>
            Register
        </button>
        
    </form>
</div>

<div class="w3-center w3-margin-top">
    <a class="w3-btn w3-white w3-text-orange w3-border" href="<?=github_url()?>">
        <i class="fa-brands fa-github fa-padding-right"></i>
        Login using GitHub
    </a>
</div>

<div class="w3-container w3-center w3-margin">
    <button
        onclick="location.href='/login';"
        class="w3-button w3-grey w3-text-white"
    >
        <i class="fa-solid fa-caret-left fa-padding-right"></i>
        Back to Login
    </button>
</div>

<script>

    async function validateExistingEmail(email) {
        return fetch('/ajax/email/exists',{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({email: email})
            })  
            .then((response)=>response.json())
            .then((responseJson)=>{return responseJson});
    }

    async function validateMainForm() {
        let errors = 0;

        let first = document.getElementById("first");
        let first_error = document.getElementById("first-error");
        first_error.innerHTML = "";
        if (first.value == "") {
            first_error.innerHTML = "(first name is required)";
            errors++;
        }

        let last = document.getElementById("last");
        let last_error = document.getElementById("last-error");
        last_error.innerHTML = "";
        if (last.value == "") {
            last_error.innerHTML = "(last name is required)";
            errors++;
        }

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
        } else {
            const json = await validateExistingEmail(email.value);
            if(json.error == true)
            {
                email_error.innerHTML = "(email already exists)";
                errors ++;
            }
        }

        let password = document.getElementById("password");
        let password_error = document.getElementById("password-error");
        password_error.innerHTML = "";
        if (password.value == "") {
            password_error.innerHTML = "(password is required)";
            errors++;
        }

        if (errors) return false;
        
        let mainForm = document.getElementById('main-form');
        mainForm.submit();
    }
</script>


<?php

include('../templates/login_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
