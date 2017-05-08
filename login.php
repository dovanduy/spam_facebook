<?php
set_time_limit(1000);
include "functions.php";
include "const.php";
$cook=realpath("cook");
$ch=curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, OPERA);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE,$cook);
curl_setopt($ch, CURLOPT_COOKIEJAR,$cook);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
curl_setopt($ch, CURLOPT_PROXY, '46.101.22.124:8118');
curl_setopt($ch, CURLOPT_URL,URL);
$page=curl_exec($ch);
var_dump1($page);
?>