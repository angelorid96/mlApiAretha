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

function pathFile($url)
{
    $prefix = '../';
    while (!is_file(sprintf('%s%s', $prefix, $url))) {
        $prefix = sprintf('%s%s', $prefix, '../');
    }

    return sprintf('%s%s', $prefix, $url);
}

function con_value_endpoint($list_values, $limit_caracter)
{
    // echo '<br>';
    // echo str_repeat('%s'.$limit_caracter, count($list_values));
    return vsprintf(str_repeat('%s' . $limit_caracter, count($list_values)), $list_values);
}
function array_is_list($array)
{
    if ($array === []) {
        return true;
    }
    return array_keys($array) === range(0, count($array) - 1);
}
$docHtml = new DOMDocument();
$tmp_json = json_decode(file_get_contents('php://input'), true);
if ($tmp_json != null) {
    $isExpireTK = isExpiredAccessToken();
    if ($isExpireTK['value']) {
        $oApiToken = new \mod_apitoken\entities\apiToken();
        $oApiToken->getPO()->setNickname($_SESSION['nickname']);
        $oApiToken->getPO()->setUser_id($_SESSION['user_id']);
        // $existUser = $oApiToken->selectByNickname();
        $existUser = $oApiToken->selectByUserID();
        // var_dump($list_menu_endpoints);
        if (count($existUser) > 0) {
            $oApiToken = $existUser[0];
            $tmp_json['EndPoint']['access_token'] = $oApiToken->getAcces_token();
            $list_required_endpoint = mlApi::data_required($tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild']);
            // echo '<br>';
            // var_dump($list_required_endpoint);
            if (is_array($list_required_endpoint)) {
                foreach ($list_required_endpoint as $key_required) {
                    if ($key_required == 'user_id') {
                        $tmp_json['EndPoint']['body']['user_id'] = $oApiToken->getUser_id();
                    } else if ($key_required == 'seller_id') {
                        $tmp_json['EndPoint']['body']['seller_id'] = $oApiToken->getUser_id();
                    } else if ($key_required == 'site_user') {
                        $tmp_json['EndPoint']['body']['site_user'] = $oApiToken->getSite_userId();
                    }
                }
            }
        
            // var_dump($tmp_json['EndPoint']);
            $response_endpoint = mlApi::request_endPoint($tmp_json['EndPoint']);

            if (key_exists('error', $response_endpoint)) {
                $response['status'] = 'warning';
                $response['code'] = '400';
                $response['message'] = 'EndPoint response with error';
                $response['endpoint_data'] = $response_endpoint;
            } else {
                if (!key_exists('reject', $response_endpoint)) {
                    $response['status'] = 'success';
                    $response['code'] = '000';
                    $response['message'] = 'get data EndPoint success';
                    if (key_exists('urlPage', $tmp_json) && $tmp_json['urlPage'] != '') {
                        $docHtml->loadHTMLFile(pathFile($tmp_json['urlPage']));
                        // $docHtml->getElementById('card-header-name')->appendChild($docHtml->createTextNode( $response_endpoint['nameEndPoint']));
                        // $cardContent=$docHtml->getElementById('card-body-content');
                        foreach (array_keys($tmp_json['listIdPage']) as $key_id) {
                            $elementID = $docHtml->getElementById($key_id);

                            // echo '<br>';
                            // var_dump($key_id);

                            if (is_array($tmp_json['listIdPage'][$key_id])) {
                                // echo ' is array <br>';
                                // var_dump($tmp_json['listIdPage'][$key_id]);
                                // echo '<br>';
                                // echo array_is_list($tmp_json['listIdPage'][$key_id]);
                                if (array_is_list($tmp_json['listIdPage'][$key_id])) {
                                    $tmp_list = array();
                                    foreach ($tmp_json['listIdPage'][$key_id] as $val) {
                                        array_push($tmp_list, $response_endpoint['data'][$val]);
                                    }
                                    // echo 'is list <br>';
                                    // var_dump($tmp_list);
                                    $elementID->appendChild($docHtml->createTextNode(con_value_endpoint($tmp_list, ' ')));
                                } else {
                                    foreach (array_keys($tmp_json['listIdPage'][$key_id]) as $key_Child_id) {
                                        // echo '<br>';
                                        // var_dump($key_Child_id);
                                        if (is_array($tmp_json['listIdPage'][$key_id][$key_Child_id])) {
                                            $tmp_list = array();
                                            foreach ($tmp_json['listIdPage'][$key_id][$key_Child_id] as $val) {
                                                array_push($tmp_list, $response_endpoint['data'][$key_Child_id][$val]);
                                            }
                                            $elementID->appendChild($docHtml->createTextNode(con_value_endpoint($tmp_list, ' ')));
                                        } else {
                                            $elementID->appendChild($docHtml->createTextNode($response_endpoint['data'][$key_Child_id][$tmp_json['listIdPage'][$key_id][$key_Child_id]]));
                                        }
                                    }
                                }
                            } else {
                                // echo '<br>';
                                // var_dump($tmp_json['listIdPage'][$key_id]);
                                $elementID->appendChild($docHtml->createTextNode($response_endpoint['data'][$tmp_json['listIdPage'][$key_id]]));
                            }
                        }
                        $response['endpoint_data'] = 'none';
                        $response['html'] = $docHtml->saveHTML($docHtml->lastChild->lastChild);
                    } else {
                        $response['endpoint_data'] = $response_endpoint;
                    }
                }
            }
        }
    }
}

// echo '<br>';
echo json_encode($response);
?>