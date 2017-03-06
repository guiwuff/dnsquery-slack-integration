<?php
/**************
/ PHP DNS Query Slack Integration
/ PHP Server Application to listen to DNS Query coming from Slack
***************/

include('DNSQuery.php');

// Config

$payload_token = 'ZdGvnv3KUSXAB7GiUEsWTZMw';

// Check Token 

if($_POST['token'] != $payload_token){ 
    $msg = "Token yang digunakan *tidak valid*, silahkan periksa kembali konfigurasi anda\n";
    $msg .= "Melalui URL <https://garudaforce2it.slack.com/apps/A0F82E8CA-slash-commands>";
    die($msg);
    echo $msg;
}

// Ambil data slashcommand dan subcommand yang dibutuhkan dari payload
$command = $_POST['command'];
$subcommand = $_POST['text'];

$dns = new DNSQuery($subcommand);
$dns->process();

if ($dns->commandstatus == 0) {
    die($dns->returnmsg);
    echo $dns->returnmsg;
}else{
    echo $dns->returnmsg;
}
?>