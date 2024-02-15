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
$responseDefault = true;
$list_endPoints = null;
$docHtml = new DOMDocument();
$tmp_json = json_decode(file_get_contents('php://input'), true);
if ($tmp_json != null) {
    if (key_exists('url', $tmp_json)) {
        if (is_file($tmp_json['url'])) {
            $docHtml->loadHTMLFile($tmp_json['url']);
        }
    } else if (key_exists('scope', $tmp_json)) {
        $list_endPoints = $tmp_json['scope'];
    }
    $responseDefault = false;
} else {
    $docHtml->loadHTMLFile('../html/auth.html');
}

function isExpiredAccessToken($date_token)
{
    $date_now = new DateTime(date("Y-m-d H:i:s"));
    $date_6hhPlus = new DateTime($date_token);
    $date_6hhPlus->modify('+6 hour');

    return ($date_now >= $date_6hhPlus) ? true : false;
}

if (isset($_REQUEST['endpoint']) && $_REQUEST['endpoint'] != '') {
    $response['auth'] = array(
        'status' => 'success',
        'url' => mlApi::getUrlAuth($_REQUEST['endpoint']),
    );
} else {

    if (isset($_SESSION['nickname']) && isset($_SESSION['user_id'])) {
        // $oApiToken = new are
        $oApiToken = new \mod_apitoken\entities\apiToken();
        $oApiToken->getPO()->setNickname($_SESSION['nickname']);
        $oApiToken->getPO()->setUser_id($_SESSION['user_id']);
        $existUser = $oApiToken->selectByNickname();
        $list_menu_endpoints = mlApi::getNames_endpoints(array('users'));
        // var_dump($list_menu_endpoints);
        if (count($existUser) > 0) {
            $oApiTokenTmp = $existUser[0];
            // echo '<br>';
            // var_dump( new DateTime($oApiToken->getDateAcces_token()));
            if (isExpiredAccessToken($oApiTokenTmp->getDateAcces_token())) {
                $response_endpoint = mlApi::request_endPoint(array('endpoint_parent' => 'auth', 'endpointChild' => 'refresh_token', 'body' => array('refresh_token' => $oApiTokenTmp->getRefresh_token()), 'method' => 'post', 'access_token' => ''));
                // $oApiToken->getPO()->setUser_id(intval($response['user_id']));
                // $oApiToken->getPO()->setNickname($response_user['nickname']);
                $oApiToken->getPO()->setAcces_token($response_endpoint['access_token']);
                $oApiToken->getPO()->setRefresh_token($response_endpoint['refresh_token']);
                $oApiToken->getPO()->setDateAcces_token(date("Y-m-d H:i:s"));
                $oApiToken->getPO()->setDateRefresh_token(date("Y-m-d H:i:s"));
                if ($oApiToken->update()) {
                    //lanzar modal para volver a logear... activar el boton de nuevo
                }
            }
            if ($responseDefault) {
                $docHtml->getElementById('nickname')->appendChild($docHtml->createTextNode($oApiToken->getPO()->getNickname()));
                foreach ($list_menu_endpoints as $key) {
                    foreach ($key as $item) {
                        $item_menu = $docHtml->createElement('a', $item[1]);
                        $item_menu->setAttribute('class', 'dropdown-item');
                        $item_menu->setAttribute('id', $item[0]);
                        $docHtml->getElementById('list-menu')->appendChild($item_menu);
                    }
                }
            } else if ($list_endPoints != null) {

            } else {

            }
            // $menu=preg_replace('[\n|\r|\n\r|\t|\0|\x0B]', '', trim($docHtml->saveHTML()));
            // echo $menu;
            $response['isAuth']['html'] =$docHtml->saveHTML();
        }
    } else {
        $response['isAuth'] = array(
            'status' => 'false',
            'html' => '<h5>Bienvenido: necesita autenticarse</h5>' .
                '<button class="btn btn-primary btn-sm" type="button" id="authML" value="authfirs">' .
                'Ir a ML' .
                '</button>',
        );
    }
}

echo json_encode($response);
