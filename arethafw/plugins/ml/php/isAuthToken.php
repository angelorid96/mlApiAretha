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
    'message'   => "",
    'isAuth'=>array(
        'status' => 'false',
        // 'html' => '<h5>Bienvenido: necesita autenticarse</h5>' .
        // '<button class="btn btn-primary btn-sm" type="button" id="authML" value="authfirs">' .
        // 'Ir a ML' .
        // '</button>',
    )
);
$list_endPoints=null;
$docHtml= new DOMDocument();
$tmp_json=json_decode(file_get_contents('php://input'), true);
if(key_exists('url',$tmp_json)){
    if(is_file($tmp_json['url'])){
        $docHtml->loadHTMLFile($tmp_json['url']);
    }
}else if(key_exists('html',$tmp_json)){
    $docHtml->loadHTML($tmp_json['html']);
}else if(key_exists('scope',$tmp_json)){
    $list_endPoints=$tmp_json['scope'];
}
    // echo $html;

function isExpiredAccessToken($date_token)
{
    // echo $date_token;
    // echo '<br>';
    $date_now = new DateTime(date("Y-m-d H:i:s"));
    $date_6hhPlus = new DateTime($date_token);
    $date_6hhPlus->modify('+6 hour');
    // var_dump($date_now);
    // echo '<br>';
    // var_dump($date_6hhPlus);
    // echo '<br>';
    // echo '<br>';
    return ($date_now >= $date_6hhPlus) ? true : false;
}

if (isset($_REQUEST['endpoint']) && $_REQUEST['endpoint'] != '') {
    $response['auth'] = array(
        'status' => 'success',
        'url' => mlApi::getUrlAuth($_REQUEST['endpoint']),
    );
} else {
    // echo mlApi::getIdApi();

    if (isset($_SESSION['nickname'])) {
        // $oApiToken = new are
        $oApiToken = new \mod_apitoken\entities\apiToken();
        $oApiToken->getPO()->setNickname($_SESSION['nickname']);
        $existUser = $oApiToken->selectByNickname();
        // var_dump($existUser);
        if (count($existUser) > 0) {
            $oApiTokenTmp = $existUser[0];
            // echo '<br>';
            // var_dump( new DateTime($oApiToken->getDateAcces_token()));
            if (isExpiredAccessToken($oApiTokenTmp->getDateAcces_token())) {
                $response_endpoint = mlApi::request_endPoint(array('endpoint' => 'refresh_token', 'body' => array('refresh_token' => $oApiTokenTmp->getRefresh_token()), 'method' => 'post', 'access_token' => ''));
                // $oApiToken->getPO()->setUser_id(intval($response['user_id']));
                // $oApiToken->getPO()->setNickname($response_user['nickname']);
                $oApiToken->getPO()->setAcces_token($response_endpoint['access_token']);
                $oApiToken->getPO()->setRefresh_token($response_endpoint['refresh_token']);
                $oApiToken->getPO()->setDateAcces_token(date("Y-m-d H:i:s"));
                $oApiToken->getPO()->setDateRefresh_token(date("Y-m-d H:i:s"));
                if ($oApiToken->update()) {
                    //lanzar modal para volver a logear... activar el boton de nuevo
                }
            }else{
                $response['isAuth'] = array(
                    'status' => 'success',
                    // 'html' => sprintf('<h5>%s</h5><i class="bi bi-person-fill"></i>', $_SESSION['nickname']),
                    'html'=>$docHtml->saveHTML(),
                );
            }
        }
    } 
}
$response['isAuth']['html']=$docHtml->saveHTML();
echo json_encode($response);
