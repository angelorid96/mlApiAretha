<?php
include "../../../Aretha.php";
include "./mlApi.class.php";
Aretha::init('../../../conf/app.ini');
mlApi::init('../conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();
$response=array(
    'status'=>'fail',
    'code'=>'001',
    'message'   =>'Surgio un problema al obtener nuevo token!',
);

function isExpiredAccessToken($date_token)
{
    $date_now = new DateTime(date("Y-m-d H:i:s"));
    $date_6hhPlus = new DateTime($date_token);
    $date_6hhPlus->modify('+6 hour');

    return ($date_now >= $date_6hhPlus) ? true : false;
}

$oApiToken = new \mod_apitoken\entities\apiToken();
$oApiToken->getPO()->setNickname($_SESSION['nickname']);
$oApiToken->getPO()->setUser_id($_SESSION['user_id']);
// $existUser = $oApiToken->selectByNickname();
$existUser = $oApiToken->selectByUserID();

// var_dump($list_menu_endpoints);
if (count($existUser) > 0) {
    $oApiTokenTmp = $existUser[0];
    
    if (isExpiredAccessToken($oApiTokenTmp->getDateAcces_token())) {
        $response_endpoint = mlApi::request_endPoint(array('endpoint_parent' => 'auth', 'endpointChild' => 'refresh_token', 'body' => array('refresh_token' => $oApiTokenTmp->getRefresh_token()), 'method' => 'post', 'access_token' => ''));

        $oApiToken->getPO()->setAcces_token($response_endpoint['access_token']);
        $oApiToken->getPO()->setRefresh_token($response_endpoint['refresh_token']);
        $oApiToken->getPO()->setDateAcces_token(date("Y-m-d H:i:s"));
        $oApiToken->getPO()->setDateRefresh_token(date("Y-m-d H:i:s"));
        if ($oApiToken->update()) {
           $response['status']='success';
           $response['code']='000';
           $response['message']='Token actulizado';
           $response['access_token']=$response_endpoint['access_token'];
        }
    }
}

echo json_encode($response);
?>