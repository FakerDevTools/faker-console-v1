<?php

setcookie('jwt', '', time() - 3600, '/', 'faker.ca', false, false);
unset($_SESSION['user']);
unset($_SESSION['application']);

setcookie('hash_id', '', time() - 1, '/', 'faker.ca');
setcookie('hash_string', '', time() - 1, '/', 'faker.ca');

message_set('Logged Out Success', 'You have successfully been logged out!');
header_redirect('/login');
