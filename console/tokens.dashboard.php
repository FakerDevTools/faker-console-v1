<?php

security_check();
admin_check();

if (isset($_GET['status'])) 
{

    $query = 'SELECT status
        FROM tokens 
        WHERE id = '.$_GET['status'].'
        AND application_id = '.$_application['id'].'
        LIMIT 1';
    $result = mysqli_query($connect, $query);    

    if(!mysqli_num_rows($result))
    {
        message_set('Status Error', 'There was an error while attempting to change the sattus or this token.', 'red');
        header_redirect('/tokens/dashboard');
    }

    $token = mysqli_fetch_assoc($result);

    $query = 'UPDATE tokens SET
        status = "'.($token['status'] == 'active' ? 'inactive' : 'active').'"
        WHERE id = '.$_GET['status'].'
        AND application_id = '.$_application['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Status Success', 'Token status has been updated.');
    header_redirect('/tokens/dashboard');
    
}
elseif (isset($_GET['delete'])) 
{

    $query = 'UPDATE tokens SET
        deleted_at = NOW()
        WHERE id = '.$_GET['delete'].'
        AND application_id = '.$_application['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Delete Success', 'Token has been deleted.');
    header_redirect('/tokens/dashboard');
    
}

define('APP_NAME', 'Tokens');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'tokens');
define('PAGE_SELECTED_SUB_PAGE', '/tokens/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT *,(
        SELECT COUNT(*)
        FROM calls
        WHERE calls.token_id = tokens.id
    ) AS calls
    FROM tokens
    WHERE application_id = "'.$_application['id'].'"
    AND deleted_at IS NULL
    ORDER BY name';
$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <i class="fa-solid fa-key"></i>
    Tokens
</h1>
<p>
    <a href="/application/dashboard">Dashboard</a> / 
    Tokens
</p>

<hr />

<h2>Keys</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th>Hash</th>
        <th class="bm-table-number">Calls</th>
        <th>Status</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['name']?>
            </td>
            <td>
                <?=string_show_hide($record['hash'])?>
            </td>
            <td>
                <?=($record['calls'])?>
            </td>
            <td>
            <a href="#" onclick="return confirmModal('Are you sure you want to shange the status of <?=$record['name']?>?', '/tokens/dashboard/status/<?=$record['id']?>');">
                    <?=$record['status']?>
                </a>
            </td>
            <td>
                <a href="/tokens/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete <?=$record['name']?>?', '/tokens/dashboard/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/tokens/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-tag fa-padding-right"></i> Add New Token
</a>

<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
