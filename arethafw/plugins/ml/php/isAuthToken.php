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
$defaultMenu = false;
$notMenu=false;
$list_menu_endpoints=null;
$orientationMenu='horizontal';
$docHtml = new DOMDocument();
$tmp_json = json_decode(file_get_contents('php://input'), true);
if ($tmp_json != null) {
    if (key_exists('url', $tmp_json)) {
        if (is_file($tmp_json['url'])) {
            $docHtml->loadHTMLFile($tmp_json['url']);
        }
    }else if (key_exists('defaultMenu', $tmp_json)){
        $defaultMenu=true;
        $list_menu_endpoints = mlApi::getNames_endpoints(array('users'));
        $docHtml->loadHTMLFile('../html/auth.html');
    }

    if (key_exists('scope', $tmp_json)) {
        // var_dump($tmp_json['scope']);
        $list_menu_endpoints = mlApi::getNames_endpoints($tmp_json['scope']);
        // var_dump($list_menu_endpoints);
    }
    if (key_exists('orientation', $tmp_json)) {
        $orientationMenu=$tmp_json['orientation'];
    }
}else{
    $notMenu=true;
    $docHtml=null;
}
// $docHtml->loadHTMLFile('../html/auth.html');
function isExpiredAccessToken($date_token)
{
    $date_now = new DateTime(date("Y-m-d H:i:s"));
    $date_6hhPlus = new DateTime($date_token);
    $date_6hhPlus->modify('+6 hour');

    return ($date_now >= $date_6hhPlus) ? true : false;
}

if (isset($_REQUEST['endpoint']) && $_REQUEST['endpoint'] != '') {
    $response['urlAuth'] = array(
        'status' => 'success',
        'url' => mlApi::getUrlAuth($_REQUEST['endpoint']),
    );
} else {

    if (isset($_SESSION['nickname']) && isset($_SESSION['user_id'])) {
        // $oApiToken = new are
        $oApiToken = new \mod_apitoken\entities\apiToken();
        $oApiToken->getPO()->setNickname($_SESSION['nickname']);
        $oApiToken->getPO()->setUser_id($_SESSION['user_id']);
        // $existUser = $oApiToken->selectByNickname();
        $existUser = $oApiToken->selectByUserID();
        
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
            if ($defaultMenu) {
                if($orientationMenu!='horizontal'){
                    // echo $orientationMenu;
                    $docHtml->getElementById('menu')->removeAttribute('class');
                    $docHtml->getElementById('menu')->setAttribute('class','nav flex-column');
                }
                $docHtml->getElementById('dropdown_user')->insertBefore($docHtml->createTextNode($oApiToken->getPO()->getNickname()));
                // var_dump($list_menu_endpoints);
                foreach ($list_menu_endpoints as $key) {
                    foreach ($key as $item) {
                        // var_dump($item[0]);
                        $item_menu = $docHtml->createElement('a', $item[1]);
                        $item_menu->setAttribute('class', 'dropdown-item');
                        $item_menu->setAttribute('id', $item[0]);
                        $docHtml->getElementById('user-menu')->appendChild($item_menu);
                    }
                }
            }else{
                // echo '<br>';  echo '<br>';  echo '<br>';
                //create Nav struct
                $nav=$docHtml->createElement('ul');
                ($orientationMenu!='horizontal')?$nav->setAttribute('class','nav flex-column'):$nav->setAttribute('class','nav');
                $nav->setAttribute('id','menu');//var_dump($list_menu_endpoints['site'][3][0]);

                foreach (array_keys($list_menu_endpoints) as $key) {

            
                    $col_item=$docHtml->createElement('div');
                    $col_item->setAttribute('class','col-md-auto');

                    $li=$docHtml->createElement('li');
                    $li->setAttribute('class','nav-item');
                    $dropdown=$docHtml->createElement('div');
                    $dropdown->setAttribute('class','dropdown');
                    $dropdown->setAttribute('id',$key);
                    $button=$docHtml->createElement('button');
                    $button->setAttribute('class','btn btn-secondary dropdown-toggle');
                    $button->setAttribute('type','button');
                    $button->setAttribute('id',sprintf('dropdown_%s',$key));
                    $button->setAttribute('data-bs-toggle','dropdown');
                    $button->setAttribute('aria-expanded','false');
                    // $button->setAttribute('style','width: 100%;');
                    $ul=$docHtml->createElement('ul');
                    $ul->setAttribute('class','dropdown-menu');
                    $ul->setAttribute('aria-labelledby',sprintf('dropdown_%s',$key));
                    // $ul->setAttribute('style','width: 100%;');
                    foreach ($list_menu_endpoints[$key] as $item) {
                      if($item[0]=='title'){
                        $button->appendChild($docHtml->createTextNode($item[1]));  
                      }else{
                        $li_item=$docHtml->createElement('li');
                        $a_item=$docHtml->createElement('a');
                        $a_item->appendChild($docHtml->createTextNode($item[1]));
                        $a_item->setAttribute('class','dropdown-item');
                        $a_item->setAttribute('id',$item[0]);

                        $li_item->appendChild($a_item);
                        $ul->appendChild($li_item);
                      }
                    }
                    if($key=='users'){
                        $nickname = $docHtml->createElement('h9');
                        $nickname->appendChild($docHtml->createTextNode($oApiToken->getPO()->getNickname()));
                        $i_icon = $docHtml->createElement('i');
                        $i_icon->setAttribute('class', 'bi bi-person-fill');
                        $nickname->appendChild($i_icon);
                        $button->appendChild($nickname);
                    }
                    $dropdown->appendChild($button);
                    $dropdown->appendChild($ul);
                    $li->appendChild($dropdown);
                    $col_item->appendChild($li);
                    $nav->appendChild($col_item);
                }
                 $docHtml->appendChild($nav);
            }
           
           
            $response['isAuth']['html']=$docHtml->saveHTML($docHtml->getElementById('menu'));
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

?>
