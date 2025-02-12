<?php

function string_hash($length = 10)
{

    $length--;
    return rand(pow(10, $length), pow(10, $length + 1) - 1);

}

function string_split_name($name)
{

    $names = explode(' ', $name);

    $result['first'] = $names[0];
    $result['last'] = $names[count($names)-1];

    return $result;

}

function string_is_base64($string)
{

    if (base64_decode($string, true) !== false) return true;
    else return false;

}
