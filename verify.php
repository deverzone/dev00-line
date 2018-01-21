<?php
$access_token = 'nn18S4hmFbfuUkRl+F8HchDPZvKKWASTSxM8ARegSiwUK2GMWJjjU17K1gENjBxkd/Lha+mLBK7nqHH5Uj3RuC08tUIY3x+uowMlwrVLQxjWQBAl5NUBHtLEfbcc2oXC5klWeUIexOgeCHvCT7xLTwdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>
