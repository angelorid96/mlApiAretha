<?php
include "../arethafw/Aretha.php";
include "../arethafw/plugins/ml/php/mlApi.class.php";
Aretha::init('../arethafw/conf/app.ini');
mlApi::init('../arethafw/plugins/ml/conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();

// echo http_response_code(200);
// header('HTTP/1.1 200 Ok'); 
if (substr(PHP_SAPI, 0, 3) == 'cgi') {
    header('Status: 200 Ok'); 
} else {
    header('HTTP/1.1 200 Ok'); 
}
header('Content-Type: application/json');
// echo 'Ok';

$tmp_json = json_decode(file_get_contents('php://input'), true);
$all_headers = getallheaders();
if ($tmp_json == null) {
    if (isset($_REQUEST)) {
        $tmp_json = $_REQUEST;
    }
}
// var_dump($_SERVER);
if ($tmp_json != null) {

    $log_file = json_decode(file_get_contents('request.json'), true);
    // $header_dunp=print_r($all_headers,true);
    // $response_dunp=print_r($tmp_json,true);
    array_push($log_file, $tmp_json);
    // $fp = file_put_contents( 'request.log', $header_dunp);
    file_put_contents('request.json', json_encode($log_file));
    // file_put_contents('request.json', json_encode($all_headers));

    // var_dump($tmp_json);
    // echo '<br>';
    // var_dump($tmp_json);

}
