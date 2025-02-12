<?php

security_check();
city_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_blank($_POST['name']) &&
        !validate_email($_POST['email']))
    {
        message_set('Invite Error', 'There was an error with the provided invitation email address.', 'red');
        header_redirect('/city/invite');
    }

    $data['invite_hash'] = string_hash();

    $query = 'INSERT INTO invites (
            email, 
            invite_hash,
            city_id,
            user_id,
            created_at,
            updated_at
        ) VALUES (
            "'.addslashes($_POST['email']).'",
            "'.addslashes($data['invite_hash']).'",
            '.$_city['id'].',
            '.$_user['id'].',
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);

    ob_start();
    include(__DIR__.'/../templates/email_invite.php');
    $message = ob_get_contents();
    ob_end_clean();

    email_send($_POST['email'], $_POST['name'], $message, 'Invitation to BrickMMO');

    message_set('Invite Success', 'Your city invitation has been sent to your new member.');
    header_redirect('/city/dashboard');
    
}

define('APP_NAME', $_city['name']);

define('PAGE_TITLE', 'Invite Member');
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
    <a href="/city/members">Members</a> / 
    Invite Member
</p>
<hr />

<h2>Invite Member</h2>

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

    <input  
        name="email" 
        class="w3-input w3-border w3-margin-top" 
        type="text" 
        id="email" 
        autocomplete="off"
    />
    <label for="email" class="w3-text-gray">
        <i class="fa-solid fa-envelope"></i>
        Email <span id="email-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Invite Member
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

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
