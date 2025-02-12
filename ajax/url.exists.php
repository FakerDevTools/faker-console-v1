<?php

if(!isset($_POST['url']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}
elseif(validate_reserved_urls($_POST['url']))
{
    header_bad_request();
    $data = array('message'=>'URL is reserved.', 'error' => true);
    return;
}

$query = 'SELECT *
    FROM users
    WHERE url = "'.addslashes($_POST['url']).'" ';
if(isset($_POST['id'])) $query .= 'AND id != '.addslashes($_POST['id']).' ';
$query .= 'LIMIT 1';
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result))
{
    $data = array('message' => 'URL exists.', 'error' => true);
}
else
{
    $data = array('message' => 'URL does not exists.', 'error' => false);
}
