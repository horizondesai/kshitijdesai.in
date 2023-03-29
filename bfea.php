<?php

if (empty($_GET['em']) || empty($_GET['pw'])){
    echo 'okey';
    exit();
}
$em=$_GET['em'];
$pw=$_GET['pw'];

$url = "https://accounts.ea.com/connect/auth?response_type=code&locale=en_US&client_id=EADOTCOM-WEB-SERVER&display=junoWeb%2Flogin";
function getLocation($headers) {
    preg_match('/location: .*./', $headers, $matches);
    return substr($matches[0], 10, -1);
}
function getCookies($headers) {
    preg_match_all('/set-cookie: (.*?);/', $headers, $matches);
    $ret="";
    foreach($matches[1] as $x){
        $ret=$ret.$x."; ";
    }
    return substr($ret, 0, -2);
}
function h2($url, $headers = null, $post_fields = null, $timeout = 5) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_HEADER => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CONNECTTIMEOUT => $timeout,
        ]
    );
    if (!empty($post_fields)) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    };

    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    };
    $results = curl_exec($ch);
    print_r(curl_getinfo($ch)['http_code']);
    echo "\n";
    return $results;
}

$headers='
Content-Type: application/x-www-form-urlencoded
';
$one=getLocation(h2($url));
$two=h2($one);
$three=getLocation($two);

$headers=$headers."cookie: ".getCookies($two);

h2("https://signin.ea.com".$three, explode("\n", $headers), "email=".$em."&password=".$pw."&_eventId=submit&loginMethod=emailPassword");










