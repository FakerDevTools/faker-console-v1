<?php

setcookie('jwt', '', time() - 3600, '/', 'brickmmo.com', false, false);
unset($_SESSION['user']);
unset($_SESSION['city']);

setcookie('hash_id', '', time() - 1, '/', 'brickmmo.com');
setcookie('hash_string', '', time() - 1, '/', 'brickmmo.com');

message_set('Logged Out Success', 'You have successfully been logged out!');
header_redirect('/login');
