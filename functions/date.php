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

function date_ago($date)
{

    if(!$date) return false;

    if(is_string($date)) $date = strtotime($date);

    $difference = $now - $date;

    /*
    echo 'Now: '.$now.'<br>';
    echo 'Date: '.$date.'<br>';
    echo 'Difference: '.$difference.'<br>';
    */

    if(abs($difference) < 60) return 'Just Now';

    if(abs($difference) < 60 * 60) $value = round(abs($difference) / (60)).' minutes';
    elseif(abs($difference) < 60 * 60 * 24) $value = round(abs($difference) / (60 * 60)).' hours';
    elseif(abs($difference) < 60 * 60 * 24 * 7) $value = round(abs($difference) / (60 * 60 * 24)).' days';
    elseif(abs($difference) < 60 * 60 * 24 * 31) $value = round(abs($difference) / (60 * 60 * 24 * 7)).' weeks';
    elseif(abs($difference) < 60 * 60 * 24 * 365) $value = round(abs($difference) / (60 * 60 * 24 * 31)).' months';
    else $value = round(abs($difference) / (60 * 60 * 24 * 365)).' years';

    return ($difference < 0 ? 'In ' : '').$value.($difference < 0 ? '' : ' ago');

}
