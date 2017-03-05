<?php
/**************
/ PHP DNS Query Slack Integration
/ PHP Server Application to listen to DNS Query coming from Slack
***************/

// Config

$payload_token = 'ZdGvnv3KUSXAB7GiUEsWTZMw';


$command = $_POST['command'];
$text = $_POST['text'];
$token = $_POST['token'];

// Check Token 

if($token != $payload_token){ 
    $msg = "Token yang digunakan tidak valid, silahkan periksa kembali konfigurasi anda";
    die($msg);
    echo $msg;
}

switch ($text) {
    case 'whois':
        $msg = "Whois";
        echo $msg;
        break;
    default:
        # code...
        break;
}
?>