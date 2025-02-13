<?php

security_check();
application_check();

if (isset($_GET['uninvite'])) 
{

    if(!$user = user_fetch($_GET['uninvite']))
    {
        message_set('Delete Error', 'There was an error removing this member from the application.', 'red');
        header_redirect('/application/members');
    }

    $query = 'DELETE FROM application_user 
        WHERE user_id = '.$user['id'].'
        AND application_id = '.$_application['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    $query = 'UPDATE users SET
        application_id = NULL
        WHERE id = '.$user['id'].'
        AND application_id = '.$_application['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    user_set_application();

    message_set('Delete Success', 'Member has been removed from this application.');
    header_redirect('/application/dashboard');
    
}

define('APP_NAME', $_application['name']);

define('PAGE_TITLE', 'Members');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT users.*,application_user.*
    FROM users
    INNER JOIN application_user ON users.id = application_user.user_id
    WHERE application_user.application_id = '.$_application['id'].'
    ORDER BY last,first';
$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    <?=$_application['name']?>
</h1>
<p>
    <a href="/application/dashboard">Dashboard</a> / 
    Members
</p>
<hr />

<h2>Members</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
        <th>Name</th>
        <th>GitHub</th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <img
                    src="<?=user_avatar($record['user_id']);?>"
                    style="height: 25px"
                    class="w3-circle"
                />
            </td>
            <td>
                <?php if($record['application_id'] == $_application['id']): ?>
                    <i class="fa-solid fa-lock"></i>
                <?php endif; ?>
            </td>
            <td>
                <?=$record['first']?> <?=$record['last']?>
            </td>
            <td>
                <?php if($record['github_username']): ?>
                    <a href="https://github.com/<?=$record['github_username']?>">
                        <i class="fa-brands fa-github"></i>
                        <?=$record['github_username']?>
                    </a>
                <?php endif; ?>
            </td>
            <td>
                <?php if($record['user_id'] != $_user['id'] && $record['user_id'] != $_application['user_id']): ?>
                    <a href="#" onclick="return confirmModal('Are you sure you want to remove <?=user_name($_user['id'])?> from <?=$_application['name']?>?', '/application/members/uninvite/<?=$record['user_id']?>');">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/application/invite/"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-envelope fa-padding-right"></i> Invite New Member
</a>
    
<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
