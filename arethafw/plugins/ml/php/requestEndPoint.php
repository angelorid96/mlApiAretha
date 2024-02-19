<?php

// include "/xampp/htdocs/MlAretha/arethafw/Aretha.php";
include "../../../Aretha.php";
include "./mlApi.class.php";
include './isExpireToken.php';

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

$docHtml = new DOMDocument();
$tmp_json = json_decode(file_get_contents('php://input'), true);
if ($tmp_json != null) {
    $isExpireTK=isExpiredAccessToken();
    if($isExpireTK['value']){
        $oApiToken = new \mod_apitoken\entities\apiToken();
        $oApiToken->getPO()->setNickname($_SESSION['nickname']);
        $oApiToken->getPO()->setUser_id($_SESSION['user_id']);
        // $existUser = $oApiToken->selectByNickname();
        $existUser = $oApiToken->selectByUserID();
        // var_dump($list_menu_endpoints);
        if (count($existUser) > 0) {
            $oApiToken = $existUser[0];
            $tmp_json['access_token']=$oApiToken->getAcces_token();
            $list_required_endpoint=mlApi::data_required($tmp_json['endpoint_parent'],$tmp_json['endpointChild']);
            // echo '<br>';
            // var_dump($list_required_endpoint);
            if(is_array($list_required_endpoint)){
                foreach($list_required_endpoint as $key_required){
                    if($key_required=='user_id'){
                        $tmp_json['body']['user_id']=$oApiToken->getUser_id();
                    }else if($key_required=='seller_id'){
                        $tmp_json['body']['seller_id']=$oApiToken->getUser_id();
                    }else if($key_required=='site_user'){
                        $tmp_json['body']['site_user']=$oApiToken->getSite_userId();
                    }
                }
            }
            // echo '<br>';
            // var_dump($tmp_json);
            $response_endpoint = mlApi::request_endPoint($tmp_json);
            if(!key_exists('reject',$response_endpoint)){
                $response['status']='success';    
                $response['code']='000';
                $response['message']='get data EndPoint success';
                $response['endpoint_data']=$response_endpoint;      
                if($tmp_json['defaultPage']){
                    $docHtml->loadHTMLFile('../html/layerDefault.html');

                    $docHtml->getElementById('card-header-name')->appendChild($docHtml->createTextNode( $response_endpoint['nameEndPoint']));
                    $cardContent=$docHtml->getElementById('card-body-content');

                    

                }      
            }
        }
    }    
}  


echo json_encode($response);
?>