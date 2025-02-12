<?php

function date_now($format = 'MYSQL')
{

    return date_to_format(time(), $format);

}

function date_to_format($date, $format = 'MYSQL')
{

    if($format == 'MYSQL') return date('Y-m-d H:i:s', $date);
    if($format == 'FULL') return date('l F jS, g:i a Y', $date);    

}
