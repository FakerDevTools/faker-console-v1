<?php

security_check();

$google = setting_fetch('GOOGLE_ACCESS_TOKEN');

google_revoke($google);

setting_update('GOOGLE_ACCESS_TOKEN', '');

message_set('Disconnection Success', 'The BrickMMO console has been disconnected from your Google account.');
header_redirect(ENV_CONSOLE_DOMAIN.'/admin/authentication/dashboard');
