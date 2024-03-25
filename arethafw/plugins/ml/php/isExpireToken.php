<?php
function isExpiredAccessToken()
{
    date_default_timezone_set('America/Mexico_City');
    $response = array(
        'status' => 'fail',
        'code' => '001',
        'message'   => 'Surgio un problema al obtener nuevo token!',
        'value' => false,
        'cause'=>'none'
    );

    $oApiToken = new \mod_apitoken\entities\apiToken();
    $oApiToken->getPO()->setNickname($_SESSION['nickname']);
    $oApiToken->getPO()->setUser_id($_SESSION['user_id']);
    // $existUser = $oApiToken->selectByNickname();
    $existUser = $oApiToken->selectByUserID();

    // var_dump($list_menu_endpoints);
    if (count($existUser) > 0) {
        $oApiTokenTmp = $existUser[0];
        // var_dump($oApiTokenTmp);
        // echo '<br>';

        $date_now = new DateTime(date("Y-m-d H:i:s"));
        $date_6hhPlus = new DateTime($oApiTokenTmp->getDateAcces_token());
        $date_6hhPlus->modify('+6 hour');

        $date_now_refresh = new DateTime(date("Y-m-d H:i:s"));
        $date_6hhPlus_refresh = new DateTime($oApiTokenTmp->getDateRefresh_token());
        $date_6hhPlus_refresh->modify('+6 month');


        $isExpireDate_refresh = ($date_now_refresh >= $date_6hhPlus_refresh) ? true : false;
        if(($oApiTokenTmp->getAcces_token()=='')||($oApiTokenTmp->getRefresh_token()=='')){
            
            $response['status'] = 'invalid';
            $response['code'] = '004';
            $response['message'] = 'acces token o refresh token indefinidos';
            $response['value'] = false;
            $response['cause'] ='acces token o refresh token no se encuentrar';

            return $response;
        }

        if ($isExpireDate_refresh) {
            $response['status'] = 'expired';
            $response['code'] = '004';
            $response['message'] = 'refresh token no valido, necesita volver autenticar';
            $response['value'] = false;
            $response['cause'] ='Tiempo valido de refresh token revasado';
        } else {
            $isExpireDate = ($date_now >= $date_6hhPlus) ? true : false;
            if ($isExpireDate) {

                $tmp_json = array(
                    'endpoint_parent' => 'auth',
                    'endpointChild' => 'refresh_token',
                    'body' => array('refresh_token' => $oApiTokenTmp->getRefresh_token()),
                    'access_token' => $oApiTokenTmp->getRefresh_token(),
                );

                $list_required_endpoint = mlApi::data_required($tmp_json['endpoint_parent'], $tmp_json['endpointChild']);
                // echo '<br>';
                // var_dump($list_required_endpoint);
                if (is_array($list_required_endpoint)) {
                    foreach ($list_required_endpoint as $key_required) {
                        if ($key_required == 'user_id') {
                            $tmp_json['body']['user_id'] = $oApiTokenTmp->getUser_id();
                        } else if ($key_required == 'seller_id') {
                            $tmp_json['body']['seller_id'] = $oApiTokenTmp->getUser_id();
                        } else if ($key_required == 'site_user') {
                            $tmp_json['body']['site_user'] = $oApiTokenTmp->getSite_userId();
                        }
                    }
                }
                $response_endpoint = mlApi::request_endPoint($tmp_json);

              

                $oApiToken->getPO()->setAcces_token($response_endpoint['data']['access_token']);
                $oApiToken->getPO()->setRefresh_token($response_endpoint['data']['refresh_token']);
                $oApiToken->getPO()->setDateAcces_token(date("Y-m-d H:i:s"));
                $oApiToken->getPO()->setDateRefresh_token(date("Y-m-d H:i:s"));
                if ($oApiToken->update()) {
                    $response['status'] = 'valid';
                    $response['code'] = '000';
                    $response['message'] = 'Token actulizado';
                    $response['value'] = true;
                }else{
                    $response['status'] = 'invalid';
                    $response['code'] = '405';
                    $response['message'] = 'no se puede actualizar';
                    $response['value'] = false;
                    if(key_exists('cause',$response_endpoint['data'])){
                        $response['cause'] =$response_endpoint['data']['cause'];
                    }
                }
            } else {
                $response['status'] = 'valid';
                $response['code'] = '000';
                $response['message'] = 'Token aun valido';
                $response['value'] = true;
            }
        }
    }
    return $response;
}
