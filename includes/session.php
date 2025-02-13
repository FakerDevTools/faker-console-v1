<?php

/*
 * Start the session
 */
session_set_cookie_params(60*60*3, null, '.faker.ca');
session_start();
