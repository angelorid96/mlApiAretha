<?php
include "../arethafw/Aretha.php";
include "../arethafw/plugins/ml/php/mlApi.class.php";
include "../arethafw/plugins/ml/php/isExpireToken.php";
Aretha::init('../arethafw/conf/app.ini');
mlApi::init('../arethafw/plugins/ml/conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();
$response = array(
    "draw"            => 1,
    "recordsTotal"    => 0,
    "recordsFiltered" => 0,
    "data"            => array()
);

function keys_datatables($columns)
{
    $keys_columns = array();

    foreach ($columns as $item) {
        if (key_exists('name', $item)) {
            array_push($keys_columns, $item['name']);
        }
    }

    return $keys_columns;
}
function fail_response_add($tmp_json)
{
    $response_tmp['draw']    = $tmp_json['draw'];
    $response_tmp['recordsTotal']    = 0;
    $response_tmp['recordsFiltered'] = 0;
    $response_tmp['data'] = [];
    // $response_tmp['error'] = sprintf('Not exits Endpoint parent %s or Endpoint child %s', $tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild']);
    $response_tmp['status'] = 'warning';
    $response_tmp['code'] = '400';
    $response_tmp['message'] = 'EndPoint response with error';
    $response_tmp['endpoint_data'] = array(
        'reject' => array(
            'status' => 'fail',
            'error' => sprintf('Not exits Endpoint parent %s or Endpoint child %s', $tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild']),
            'cause' => sprintf('Invalid name  Endpoint parent %s or Endpoint child %s', $tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild'])
        ),
    );
    return $response_tmp;
}

$tmp_json = json_decode(file_get_contents('php://input'), true);
if ($tmp_json == null) {
    $tmp_json = $_REQUEST;
}
// var_dump($tmp_json['columns']);
if ($tmp_json != null) {
    $isExpireTK = isExpiredAccessToken();
    if ($isExpireTK['value']) {
        if (mlApi::exist_endPoint_Child($tmp_json['EndPoint']['endpoint_parent'], $tmp_json['EndPoint']['endpointChild'])) {
            $oApiToken = new \mod_apitoken\entities\apiToken();
            $oApiToken->getPO()->setNickname($_SESSION['nickname']);
            $oApiToken->getPO()->setUser_id($_SESSION['user_id']);
            // $existUser = $oApiToken->selectByNickname();
            $existUser = $oApiToken->selectByUserID();
            // var_dump($list_menu_endpoints);
            if (count($existUser) > 0) {
                $oApiToken = $existUser[0];
                $tmp_json['EndPoint']['access_token'] = $oApiToken->getAcces_token();
                $tmp_json['EndPoint']['childData']['access_token'] = $oApiToken->getAcces_token();

                if (array_key_exists('paging', $tmp_json['EndPoint']['childData'])) {
                    $tmp_json['EndPoint']['paging']['childData']['offset'] = $tmp_json['start'];
                    $tmp_json['EndPoint']['paging']['childData']['limit'] = $tmp_json['length'];
                }

                if (array_key_exists('paging', $tmp_json['EndPoint'])) {
                    $tmp_json['EndPoint']['paging']['offset'] = $tmp_json['start'];
                    $tmp_json['EndPoint']['paging']['limit'] = $tmp_json['length'];
                }
                // $response['limit'] = $oApiToken->getAcces_token();
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
                $response_endpoint = mlApi::request_endPoint($tmp_json['EndPoint']);
                // var_dump($response_endpoint);
                if (!key_exists('reject', $response_endpoint)) {
                    if (key_exists('childData', $tmp_json['EndPoint'])) {
                        if (mlApi::exist_endPoint_Child($tmp_json['EndPoint']['childData']['endpoint_parent'], $tmp_json['EndPoint']['childData']['endpointChild'])) {
                            $keys_columns = keys_datatables($tmp_json['columns']);
                            $response['draw']    = $tmp_json['draw'];
                            $response['recordsTotal']    = $response_endpoint['data']['paging']['total'];
                            $response['recordsFiltered'] = $response_endpoint['data']['paging']['limit'];
                            foreach ($response_endpoint['data']['results'] as $item_id) {
                                $tmp_json['EndPoint']['childData']['body']['item_id'] = $item_id;
                                $item_ml = mlApi::request_endPoint($tmp_json['EndPoint']['childData']);
                                $new_row = array();

                                // var_dump($keys_columns);
                                // echo '<br>';
                                foreach ($keys_columns as $name) {
                                    if ($name != '') {
                                        if ($name == 'thumbnail') {
                                            array_push($new_row, sprintf('<img src="%s" class="img-thumbnail" >', $item_ml['data'][$name]));
                                        } else if ($name == 'permalink') {
                                            array_push($new_row, sprintf('<a href="%s" >ver publicacion</a>', $item_ml['data'][$name]));
                                        } else {
                                            array_push($new_row, $item_ml['data'][$name]);
                                        }
                                    }
                                }
                                $btn = sprintf('<a class="btn btn-primary" id="mod-item" href="#" id-item="%s" role="button">modificar</a>', $item_ml['data']['id']);
                                if (($item_ml['data']['status'] == 'Under_review') && (in_array('Waiting_for_patch', $item_ml['data']['sub_status']))) {
                                    $btn = sprintf('%s <a class="btn btn-primary" id="infra" href="#" id-item="%s" role="button">ver infracciones</a>', $btn, $item_ml['data']['id']);
                                }
                                $btn = sprintf('<a class="btn btn-primary" id="mod-item" href="#" id-item="%s" role="button">modificar</a>', $item_ml['data']['id']);
                                array_push($new_row, $btn);
                                $response['data'][] = $new_row;
                            }
                        } else {
                            $response=fail_response_add(array('draw'=>$tmp_json['draw'],'EndPoint'=>$tmp_json['EndPoint']['childData']));
                        }
                    }
                } else {
                    $response=fail_response_add($tmp_json);
                }
            }
        } else {
            $response=fail_response_add($tmp_json);
        }
    }
}

// echo '<br>';
echo json_encode($response);
