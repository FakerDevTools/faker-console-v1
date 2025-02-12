<?php

security_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_blank($_POST['url']) || 
        !validate_alpha_numeric($_POST['url']) || 
        validate_reserved_urls($_POST['url']) ||
        validate_url_exists($_POST['url'], 'cities', $_city['id']))
    {
        die('here');
        message_set('URL Error', 'There was an error with your city URL.', 'red');
        header_redirect('/city/url');
    }

    $query = 'UPDATE cities SET
        url = "'.addslashes($_POST['url']).'"
        WHERE id = '.$_city['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    // Start session and store user data
    security_set_user_session($_user['id']);

    message_set('Password Success', 'Your city URL has been updated.');
    header_redirect('/city/dashboard');
    
}

define('APP_NAME', $_city['name']);

define('PAGE_TITLE', 'URL');
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
    Change URL
</p>
<hr />

<h2>Change URL</h2>

<?php if(!$_city['url']): ?>
    <p>
        Adding a URL to your city profile will make your city publicly visable at:
        <br />
        <a href="#"><?=ENV_CONSOLE_DOMAIN?>/profile/<span id="city-url">&lt;CITY_URL&gt;</span></a>
    </p>
<?php else: ?>
    <p>
        Your city profile is currently available at:
        <br />
        <a href="<?=ENV_CONSOLE_DOMAIN?>/profile/<?=$_city['url']?>"><?=ENV_CONSOLE_DOMAIN?>/profile/<span id="your-url"><?=$_city['url']?></span></a>
    </p>
    <p>
        Changing your city URL will cause your previous URL to no longer function and it will become available
        for another builder to use.
    </p>
<?php endif; ?>

<form
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="url" 
        class="w3-input w3-border" 
        type="text" 
        id="url" 
        autocomplete="off"
        value="<?=$_city['url']?>"
    />
    <label for="password" class="w3-text-gray">
        <i class="fa-solid fa-globe"></i>
        URL <span id="url-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="validateMainForm(); return false;">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update URL
    </button>
</form>

<script>

    let url = document.getElementById("url");
    let your_url = document.getElementById('your-url');
    url.addEventListener('keyup', (e) => {
        if(e.target.value)
        {
            your_url.innerHTML = e.target.value;
        }
        else
        {
            your_url.innerHTML = '&lt;YOUR_URL&gt;';
        }
    });

    async function validateExistingUrl(url) {
        return fetch('/ajax/url/exists',{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({url: url, id: <?=$_user['id']?>})
            })  
            .then((response)=>response.json())
            .then((responseJson)=>{return responseJson});
    }

    async function validateMainForm() {
        const alphaNumeric = new RegExp(/[^a-zA-Z0-9]/g);

        let errors = 0;

        let url = document.getElementById("url");
        let url_error = document.getElementById("url-error");
        url_error.innerHTML = "";
        if (url.value == "") 
        {
            url_error.innerHTML = "(URL is required)";
            errors++;
        }
        else if (url.value.length < 3) 
        {
            url_error.innerHTML = "(URL must be at least 3 characters)";
            errors++;
        } 
        else if (alphaNumeric.test(url.value)) 
        {
            url_error.innerHTML = "(URL may only contain letters and numbers)";
            errors++;
        } 
        else 
        {
            const json = await validateExistingUrl(url.value);
            if(json.error == true)
            {
                url_error.innerHTML = "(URL already exists)";
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
