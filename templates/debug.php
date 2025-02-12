<?php

/*
 * Dump data
 * 
 * This code ouputs all form, URL, session, and cookie data
 * if the ENV_DEBUG variable in the .env file is set to true.
 */
if(ENV_DEBUG)
{
    debug_pre($_GET);
    debug_pre($_POST);
    debug_pre($_SESSION);
    debug_pre($_COOKIE);
    // debug_pre(get_defined_constants());
}
