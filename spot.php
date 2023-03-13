<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$client_id = getenv('myclientid');
$client_secret = getenv('myclientsecret');

// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret)));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//setting user agent so request looks like its coming from a legitimate browser
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:x.x.x) Gecko/20041107 Firefox/x.x");
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//pass url to browser
$json = curl_exec($ch);

//Store JSON data in a PHP variable, and then decode it into a PHP object: 
$json = json_decode($json);

// close cURL resource, and free up system resources
curl_close($ch);


//print json token, type and expires in 
echo '<pre>' . print_r($json, true) . '</pre>';
echo $json->access_token;

//SECOND CALL to use the json token generated 
$authorization = "Authorization: Bearer " . $json->access_token;

$artist = 'Hermitude';

$spotifyURL = 'https://api.spotify.com/v1/search?q=' . urlencode($artist) . '&type=artist';

$ch2 = curl_init();


curl_setopt($ch2, CURLOPT_URL, $spotifyURL);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:x.x.x) Gecko/20041107 Firefox/x.x");
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
$json2 = curl_exec($ch2);
$json2 = json_decode($json2);
curl_close($ch2);

echo '<pre>' . print_r($json2, true) . '</pre>';




?>