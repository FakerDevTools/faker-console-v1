<?php

security_check();

$github = setting_fetch('GITHUB_ACCESS_TOKEN');

github_revoke($github);

setting_update('GITHUB_ACCESS_TOKEN', '');

message_set('Disconnection Success', 'The BrickMMO console has been disconnected from your GitHub account.');
header_redirect(ENV_CONSOLE_DOMAIN.'/admin/authentication/dashboard');
