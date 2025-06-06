<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'UPDATE ips SET
        deleted_at = NOW()
        WHERE id = '.$_GET['delete'].'
        AND application_id = '.$_application['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Delete Success', 'IP Address has been deleted.');
    header_redirect('/access/dashboard');
    
}
elseif (isset($_GET['block'])) 
{

    $query = 'UPDATE ips SET
        status = "blocked"
        WHERE id = '.$_GET['block'].'
        AND application_id = '.$_application['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Block Success', 'IP Address has been blocked.');
    header_redirect('/access/dashboard');
    
}

define('APP_NAME', 'Access');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'access');
define('PAGE_SELECTED_SUB_PAGE', '/access/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT *,(
        SELECT MAX(created_at)
        FROM calls
        WHERE calls.ip_id = ips.id
        LIMIT 1
    ) AS max_created_at,(
        SELECT COUNT(id)
        FROM calls
        WHERE calls.ip_id = ips.id
        AND result = "success"
        LIMIT 1
    ) AS calls
    FROM ips
    WHERE application_id = "'.$_application['id'].'"
    AND status = "allowed"
    AND deleted_at IS NULL
    ORDER BY address';
$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <i class="fa-solid fa-server"></i>
    IP Address Access
</h1>
<p>
    <a href="/application/dashboard">Dashboard</a> / 
    IP Address Access
</p>

<hr />

<h2>IP Address Access</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>IP Address</th>
        <th>Last Accessed</th>
        <th class="bm-table-number">Calls</th>
        <th></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['address']?>
            </td>
            <td>
                <?=date_ago($record['max_created_at'])?>
            </td>
            <td class="bm-table-number">
                <?=$record['calls']?>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to block <?=$record['address']?>?', '/access/dashboard/block/<?=$record['id']?>');">
                    Block IP
                </a>
            </td>
            <td class="bm-table-icon">
                <a href="#" onclick="return confirmModal('Are you sure you want to delete <?=$record['address']?>?', '/access/dashboard/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/access/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-tag fa-padding-right"></i> Add New IP Address
</a>

<?php

include('../templates/modal_application.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
