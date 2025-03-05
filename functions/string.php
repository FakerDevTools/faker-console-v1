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

function string_show_hide($hash)
{

    $html = '<div>
            <span class="hide_content">'.str_repeat('*', strlen($hash)).'</span>
            <span class="show_content copy_button" style="display:none;">'.$hash.'</span>
            <a href="#" class="show_button">show</a>
            <a href="#" class="hide_button" style="display:none;">hide</a>
        </div>';

    return $html;

}
