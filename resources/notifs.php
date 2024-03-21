<?php
include "../arethafw/Aretha.php";
include "../arethafw/plugins/ml/php/mlApi.class.php";
Aretha::init('../arethafw/conf/app.ini');
mlApi::init('../arethafw/plugins/ml/conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();

header('Content-Type: application/json');

$tmp_json = file_get_contents('php://input');
$all_headers = getallheaders();

if ($tmp_json != null) {
    
    $log_file=json_decode(file_get_contents('request.json'),true);
    $tmp_json=json_decode($tmp_json,true);
    // $header_dunp=print_r($all_headers,true);
    // $response_dunp=print_r($tmp_json,true);
    array_push($log_file,$tmp_json);
    // $fp = file_put_contents( 'request.log', $header_dunp);
   file_put_contents('request.json',json_encode($log_file));

    // var_dump($tmp_json);
    // echo '<br>';
    // var_dump($tmp_json);

    
}


?>