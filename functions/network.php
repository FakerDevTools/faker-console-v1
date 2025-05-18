<?php

function network_ip_address()
{
    
    if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])) 
    {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }

    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip_address = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip_address = $forward;
    }
    else
    {
        $ip_address = $remote;
    }

    return $ip_address;

}

function network_url()
{

    return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

}

function network_valid($address)
{

    if(!filter_var($address, FILTER_VALIDATE_URL))
    {
        return false;
    }
    
    $curlInit = curl_init($address);
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

    $response = curl_exec($curlInit);

    curl_close($curlInit);

    if ($response) return true;
    return false;
       
}