<?php
$ch=curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE,realpath("cookies"));
curl_setopt($ch, CURLOPT_COOKIEJAR,realpath("cook"));
curl_setopt($ch,CURLOPT_URL,"https://www.facebook.com/");
echo curl_exec($ch);
?>