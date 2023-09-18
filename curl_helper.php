<?php
function curlpost($endpoint, $data)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,$endpoint);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $returned = curl_exec($ch);
    curl_close($ch);

    return $returned;
}

function curlget($endpoint,$payload)
{
    $header[] = "Accept: application/json";
    $header[] = "Content-Type: application/json";
    $header[] = "Authorization: Basic ".base64_encode($payload.":");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$endpoint);
    curl_setopt($ch, CURLOPT_HTTPGET,1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $returned = curl_exec($ch);
    curl_close($ch);

    return $returned;
}

function midpost($endpoint,$payload)
{
    $header[] = "Accept: application/json";
    $header[] = "Content-Type: application/json";
    $header[] = "Authorization: Basic ".base64_encode($payload.":");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$endpoint);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $returned = curl_exec($ch);
    curl_close($ch);

    return $returned;
}

function rajaongkirget($endpoint,$header)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,$endpoint);
    curl_setopt($ch, CURLOPT_HTTPGET,1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $returned = curl_exec($ch);
    curl_close($ch);

    return $returned;
}

function rajaongkirpost($endpoint,$data)
{
    $m['header'] = "content-type: application/x-www-form-urlencoded";
    $m['header'] = "key: a3ed7c6e61d1515858c172ae7c6e5119";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,$endpoint);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$m);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $returned = curl_exec($ch);
    curl_close($ch);

    return $returned;
}