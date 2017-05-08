<?php
set_time_limit(1000000);
include "functions.php";
include "const.php";
var_dump1($_SERVER);
$str="qwertyuiopasdfghjklmnbvcxz1234567890";
$handle = fopen ("php://stdin","r");
while(true){
    $mailId="";
    for($i=0;$i<8;$i++)$mailId.=$str[rand(0,35)];
    $mailId.="@cartelera.org";
    $cook='cookies/'.$mailId;
    if(!file_exists($cook)){
        $tf=fopen($cook,'w');
        fclose($tf);
    }
    $cook=realpath($cook);
    $ip='123.145.132.151';
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, OPERA);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE,$cook);
    curl_setopt($ch, CURLOPT_COOKIEJAR,$cook);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
    while(!isset($name[1])) {
        $page = file_get_contents(FAKENAME);
        preg_match('%<h3>([^<]*)%', $page, $name);
    }
    preg_match('%^[^ ]*%', $name[1], $fName);
    preg_match('%[^ ]*$%', $name[1], $lName);
    $fName=$fName[0];
    $lName=$lName[0];
    curl_setopt($ch,CURLOPT_URL,REG);
    do{$page=curl_exec($ch);}while($page==false);
    preg_match('%<form .*</form>%s',$page,$form);
    splitForm($form[0],$action,$fields);
    $fields["firstname"]=$fName;
    $fields["lastname"]=$lName;
    $fields["reg_email__"]=$mailId;
    $fields["sex"]="1";
    $fields["birthday_day"]=rand(1,28);
    $fields["birthday_month"]=rand(1,12);
    $fields["birthday_year"]=rand(1970,1990);
    $fields["reg_passwd__"]=$mailId;
    $fields["submit"]="Sign Up";
    curl_setopt($ch,CURLOPT_URL,html_entity_decode($action));
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($fields));
    do{$page=curl_exec($ch);}while($page==false);
    echo $page;
    while(strpos($page,"Please enter the text below")){
        $captPage = fopen ("capt.html","w");
        fprintf($captPage,"%s",$page);
        fflush($captPage);
        preg_match('%<form .*</form>%',$page,$form);
        splitForm($form[0],$action,$fields);
        unset($fields["captcha_try_text"]);
        echo "Captcha code:\x07";
        $fields["captcha_response"]=fgets($handle);
        curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($fields));
        $page=curl_exec($ch);
    }
    fprintf(fopen("result.html","w"),"%s",$page);
    curl_close($ch);
    if(strpos($page,"Invalid Email Address")){
        echo "invalid mail.\n";
        continue;
    }
    curl_setopt($ch,CURLOPT_POST,0);
    $md5=md5($mailId);
    curl_setopt($ch,CURLOPT_URL,"http://api.temp-mail.ru/request/mail/id/$md5/");
    $confLink=null;
    while(!isset($confLink[0])){
        echo "get confirmation link.\n";
        $page=curl_exec($ch);
        preg_match('%confirmemail\.php[^"]*%',$page,$confLink);
    }
    curl_setopt($ch,CURLOPT_URL,"https://www.facebook.com/n/?".html_entity_decode($confLink[0]));
    curl_setopt($ch, CURLOPT_USERAGENT, CHROME);
    $page=curl_exec($ch);
    echo $page;
    echo "mail verified.\n";
    while(strpos($page,"Please enter the text below")){
        echo "captcha after mail.\n";
        $captPage = fopen ("capt.html","w");
        fprintf($captPage,"%s",$page);
        fflush($captPage);
        preg_match('%<form .*</form>%',$page,$form);
        splitForm($form[0],$action,$fields);
        unset($fields["captcha_try_text"]);
        echo "Captcha code:\x07";
        $fields["captcha_response"]=fgets($handle);
        curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($fields));
        $page=curl_exec($ch);
    }
    echo "success.\n";
    file_put_contents("result.html",$page);
    curl_close($ch);
}
?>