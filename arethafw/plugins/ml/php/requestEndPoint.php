<?php
include "../../../Aretha.php";
include "./mlApi.class.php";
include './isExpireToken.php';

Aretha::init('../../../conf/app.ini');
mlApi::init('../conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();

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
$files_length = 0;
$files = array();
$tmp_json = json_decode(file_get_contents('php://input'), true);

if (isset($_REQUEST['filesLength']) && $_REQUEST['filesLength'] != '') {
    $files_length = intval($_REQUEST['filesLength']);
}
if ($tmp_json == null) {
    if (isset($_REQUEST['data']) && $_REQUEST['data'] != '') {
        $tmp_json = json_decode($_REQUEST['data'], true);
    }
}
// var_dump($tmp_json);
// echo '<br>';
// var_dump($files);
// echo '<br>';

for ($i = 0; $i < $files_length; $i++) {
    // var_dump($_FILES['file'.$i]); 
    $files[] = $_FILES['file' . $i];
}

// var_dump($files);


if ($tmp_json != null) {
    $isExpireTK = isExpiredAccessToken();
    $response_endpoint = null;
    if ($isExpireTK['value']) {
        if (mlApi::exist_endPoint_Child($tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild'])) {
            $oApiToken = new \mod_apitoken\entities\apiToken();
            $oApiToken->getPO()->setNickname($_SESSION['nickname']);
            $oApiToken->getPO()->setUser_id($_SESSION['user_id']);
            $existUser = $oApiToken->selectByUserID();
            if (count($existUser) > 0) {
                $oApiToken = $existUser[0];
                $tmp_json['EndPoint']['access_token'] = $oApiToken->getAcces_token();

                // if (array_key_exists('paging', $tmp_json['EndPoint']['childData'])) {
                //     $tmp_json['EndPoint']['paging']['childData']['offset'] = $tmp_json['start'];
                //     $tmp_json['EndPoint']['paging']['childData']['limit'] = $tmp_json['length'];
                // }

                $list_required_endpoint = mlApi::data_required($tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild']);

                if (is_array($list_required_endpoint)) {
                    foreach ($list_required_endpoint as $key_required) {
                        if ($key_required == 'user_id') {
                            $tmp_json['EndPoint']['body']['user_id'] = $oApiToken->getUser_id();
                        } else if ($key_required == 'seller_id') {
                            $tmp_json['EndPoint']['body']['seller_id'] = $oApiToken->getUser_id();
                        } else if ($key_required == 'site_user') {
                            $tmp_json['EndPoint']['body']['site_user'] = $oApiToken->getSite_userId();
                        } else if ($key_required == 'site_id') {
                            $tmp_json['EndPoint']['body']['site_id'] = $oApiToken->getSite_userId();
                        }
                    }
                }

                if (count($files) > 0) {
                    $response_endpoint['data'] = array();
                    $opImgApi = new \mod_apitoken\entities\imgApi();
                    $tmp_response = null;
                    for ($i = 0; $i < $files_length; $i++) {
                        $tmp_json['EndPoint']['body']['file'] = $files[$i];
                        $tmp_response = mlApi::request_endPoint($tmp_json['EndPoint']);
                        if (!key_exists('reject', $tmp_response)) {
                            $response_endpoint['data'][] = $tmp_response['data']['id'];
                            $opImgApi->getPO()->setId($tmp_response['data']['id']);
                            $opImgApi->insert();
                        }
                        // $tmp_response = array('data' => array('id' => '748085-MLM74866745172_032024'.$i), 'nameEndPoint' => 'Subir imagen');
                        // if (!key_exists('reject', $tmp_response)) {
                        //     $response_endpoint['data'][] = $tmp_response['data']['id'];
                        //     $opImgApi->getPO()->setId($tmp_response['data']['id']);
                        //     $opImgApi->insert();
                        // }
                        // $response_endpoint['data'][] = $tmp_response['data'];
                    }
                    $response_endpoint['nameEndPoint'] = $tmp_response['nameEndPoint'];
                } else {
                    $response_endpoint = mlApi::request_endPoint($tmp_json['EndPoint']);
                }



                if (key_exists('reject', $response_endpoint)) {
                    $response['status'] = 'warning';
                    $response['code'] = '400';
                    $response['message'] = 'EndPoint response with error';
                    $response['endpoint_data'] = $response_endpoint;
                } else {
                    if (key_exists('urlPage', $tmp_json) && $tmp_json['urlPage'] != '') {
                        $docHtml->loadHTMLFile(pathFile($tmp_json['urlPage']));
                        foreach (array_keys($tmp_json['listIdPage']) as $key_id) {
                            $elementID = $docHtml->getElementById($key_id);
                            if (is_array($tmp_json['listIdPage'][$key_id])) {

                                if (array_is_list($tmp_json['listIdPage'][$key_id])) {
                                    $tmp_list = array();
                                    foreach ($tmp_json['listIdPage'][$key_id] as $val) {
                                        array_push($tmp_list, $response_endpoint['data'][$val]);
                                    }

                                    $elementID->appendChild($docHtml->createTextNode(con_value_endpoint($tmp_list, ' ')));
                                } else {
                                    foreach (array_keys($tmp_json['listIdPage'][$key_id]) as $key_Child_id) {

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

                                $elementID->appendChild($docHtml->createTextNode($response_endpoint['data'][$tmp_json['listIdPage'][$key_id]]));
                            }
                        }
                        $response['endpoint_data'] = 'none';
                        $response['html'] = $docHtml->saveHTML($docHtml->lastChild->lastChild);
                    } else {
                        $response['endpoint_data'] = $response_endpoint;
                    }
                    $response['status'] = 'success';
                    $response['code'] = '000';
                    $response['message'] = $response_endpoint['nameEndPoint'];
                }
            }
        } else {
            $response['status'] = 'warning';
            $response['code'] = '400';
            $response['message'] = 'EndPoint response with error';
            $response['endpoint_data'] = array(
                'reject' => array(
                    'status' => 'fail',
                    'error' => sprintf('Not exits Endpoint parent %s or Endpoint child %s', $tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild']),
                    'cause' => sprintf('Invalid name  Endpoint parent %s or Endpoint child %s', $tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild'])
                ),
            );
        }
    }
}


echo json_encode($response);
