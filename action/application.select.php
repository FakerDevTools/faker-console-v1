<?php

security_check();

$_application = application_fetch($_GET['id']);

user_set_application($_user['id'], $_application['id']);

security_set_user_session($_user['id']);

message_set('Application Selection Success', 'You are now working on '.$_application['name'].'.');
header_redirect(ENV_CONSOLE_DOMAIN.'/application/dashboard');
