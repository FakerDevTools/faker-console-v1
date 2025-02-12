<?php

security_check();

github_revoke($_user['github_access_token']);

$query = 'UPDATE users SET
    github_username = "",
    github_access_token = ""
    WHERE id = '.$_user['id'].'
    LIMIT 1';
mysqli_query($connect, $query);

security_set_user_session($_user['id']);

message_set('Disconnection Success', 'Your BrickMMO account has been disconnected from your GitHub account.');
header_redirect('/account/dashboard');
