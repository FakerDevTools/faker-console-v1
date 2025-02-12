<?php

security_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_email($_POST['email']) || 
        !validate_blank($_POST['first']) || 
        !validate_blank($_POST['last']) || 
        validate_email_exists($_POST['email'], 'users', $_user['id']))
    {
        message_set('Profile Error', 'There was an error with your profile information.', 'red');
        header_redirect('/account/profile');
    }

    $query = 'UPDATE users SET
        first = "'.addslashes($_POST['first']).'",
        last = "'.addslashes($_POST['last']).'",
        email = "'.addslashes($_POST['email']).'"
        WHERE id = '.$_user['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    // Start session and store user data
    security_set_user_session($_user['id']);

    message_set('Profile Success', 'Your profile has been updated.');
    header_redirect('/account/dashboard');
    
}

define('APP_NAME', 'My Account');

define('PAGE_TITLE', 'My Profile');
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
    My Profile
</p>
<hr />

<h2>My Profile</h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="first" 
        class="w3-input w3-border" 
        type="text" 
        id="first" 
        autocomplete="off"
        value="<?=$_user['first']?>"
    />
    <label for="first" class="w3-text-gray">
        First Name <span id="first-error" class="w3-text-red"></span>
    </label>

    <input 
        name="last" 
        class="w3-input w3-margin-top w3-border" 
        type="text" 
        id="last" 
        autocomplete="off"
        value="<?=$_user['last']?>"
    />
    <label for="last" class="w3-text-gray">
        Last Name <span id="last-error" class="w3-text-red"></span>
    </label>

    <input 
        name="email" 
        class="w3-input w3-border w3-margin-top" 
        type="email" 
        id="email" 
        autocomplete="off" 
        value="<?=$_user['email']?>"
    />  
    <label for="email" class="w3-text-gray">
        <i class="fa-solid fa-envelope"></i>
        Email <span id="email-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="validateMainForm(); return false;">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Profile
    </button>
</form>

<script>

    async function validateExistingEmail(email) {
        return fetch('/ajax/email/exists',{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({email: email, id: <?=$_user['id']?>})
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

        if (errors) return false;
        
        let mainForm = document.getElementById('main-form');
        mainForm.submit();
    }

</script>
    
<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
