<?php

// include "/xampp/htdocs/MlAretha/arethafw/Aretha.php";
include "../../../Aretha.php";
include "./mlApi.class.php";
Aretha::init('../../../conf/app.ini');
mlApi::init('../conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();
// include "../../../dao/DataAccess.class.php";
$response = array(
    'status'    => "fail",
    'code'      => "001",
    'message'   => "none",

);

function request_php($url){
    
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_HEADER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
$tmp_json = json_decode(file_get_contents('php://input'), true);
if ($tmp_json != null) {
    
}else if (isset($_REQUEST['endpoint']) && $_REQUEST['endpoint'] != '') {

}
var_dump(request_php('./isAuthToken.php'));

?>