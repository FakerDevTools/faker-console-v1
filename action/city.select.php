<?php

security_check();

$_city = city_fetch($_GET['id']);

user_set_city($_user['id'], $_city['id']);

security_set_user_session($_user['id']);

message_set('City Selection Success', 'You are now working on '.$_city['name'].'.');
header_redirect(ENV_CONSOLE_DOMAIN.'/city/dashboard');
