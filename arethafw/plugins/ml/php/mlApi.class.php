<?php
// namespace aretha\plugins;
class mlApi
{

    private static $iniFilePath        = "app.ini";
    private static $isIniFile          = false;
    private static $confapiML = null;

    public function __construct()
    {
    }
    public static function allErrors()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
    //===================================================================================================
    //===================================================================================================
    //  Load id app and secret id API ML
    //===================================================================================================
    //===================================================================================================
    public static function init($iniFile = "")
    {
        mlApi::$list_endPoints = json_decode(file_get_contents('/xampp/htdocs/MlAretha/arethafw/plugins/ml/conf/endPoint.json'), true);
        if (trim($iniFile) != "" && mlApi::endsWith($iniFile, ".ini")) {
            if (is_file($iniFile)) {
                mlApi::$confapiML = parse_ini_file($iniFile, true);
                mlApi::$isIniFile = true;
            }
        } else {
            if (is_file(mlApi::$iniFilePath)) {
                mlApi::$confapiML = parse_ini_file(mlApi::$iniFilePath, true);
                mlApi::$isIniFile = true;
            }
        }

        if (mlApi::$isIniFile) {
            if (isset(mlApi::$confapiML['api_settings']['default'])) {
                $default = mlApi::$confapiML['api_settings']['default'];

                mlApi::$cliend_id = mlApi::$confapiML['api_settings'][$default]['id'];
                mlApi::$cliend_secret = mlApi::$confapiML['api_settings'][$default]['secret'];
                mlApi::$url_redirect = mlApi::$confapiML['api_settings'][$default]['url_redirect'];
            }
        }
    }
    //===================================================================================================
    //===================================================================================================
    // Data Validators
    //===================================================================================================
    //===================================================================================================
    public static function startsWith($haystack, $needle)
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    public static function endsWith($haystack, $needle)
    {
        return substr($haystack, -strlen($needle)) === $needle;
    }


    //===================================================================================================
    //===================================================================================================
    // Vars id app and secret app API ML
    //===================================================================================================
    //===================================================================================================

    private static $cliend_id = "";
    private static $cliend_secret = "";
    private static $url_redirect = "";
    private static $list_endPoints = null;

    public static function getClient_id()
    {
        return mlApi::$cliend_id;
    }
    public static function getClient_secret()
    {
        return mlApi::$cliend_secret;
    }
    public static function getUrl_redirect()
    {
        return mlApi::$url_redirect;
    }
    public static function getEndPointChild($endPoint_parent, $endPoint)
    {
        // echo $endPoint;
        if (key_exists($endPoint_parent, mlApi::$list_endPoints) && key_exists($endPoint, mlApi::$list_endPoints[$endPoint_parent])) {
            return mlApi::$list_endPoints[$endPoint_parent][$endPoint];
        }
        return false;
    }
    public static function exist_endPoint($key_endPoint)
    {
        return key_exists($key_endPoint, mlApi::$list_endPoints);
    }
    public static function getUrlAuth($endPoint)
    {
        return sprintf(mlApi::getEndPointChild('auth', $endPoint), mlApi::getClient_id(), mlApi::getUrl_redirect());
    }
    public static function getNames_endpoints($keys_endpoints)
    {
        $tmpKeys_menu = array();
        foreach ($keys_endpoints as $key) {
            if (mlApi::exist_endPoint($key)) {
                // var_dump(mlApi::$list_endPoints['users']);
                // echo '<br>';
                foreach (array_keys(mlApi::$list_endPoints[$key]) as $item_key) {
                    if (is_array(mlApi::$list_endPoints[$key][$item_key])) {
                        // var_dump(mlApi::$list_endPoints[$key][$item_key]['name']);
                        // echo '<br>';
                        $tmpKeys_menu[$key][] = array($item_key, mlApi::$list_endPoints[$key][$item_key]['name']);
                    }
                }
                if(key_exists('title',mlApi::$list_endPoints[$key])&& mlApi::$list_endPoints[$key]['title']!='none'){
                    // echo '<br>';
                    // echo mlApi::$list_endPoints[$key]['title'];
                    $tmpKeys_menu[$key][] = array('title', mlApi::$list_endPoints[$key]['title']);
                    // echo '<br>';
                }
            }
        }
        // var_dump($tmpKeys_menu);
        return $tmpKeys_menu;
    }
    public static function data_required($endPoint_parent, $endPoint){
         // echo $endPoint;
         if (key_exists($endPoint_parent, mlApi::$list_endPoints) && key_exists($endPoint, mlApi::$list_endPoints[$endPoint_parent])) {
            if(mlApi::$list_endPoints[$endPoint_parent][$endPoint]['required']!='none'){
                return explode(',',mlApi::$list_endPoints[$endPoint_parent][$endPoint]['required']);
            }
        }
        return false;
    }
    // ===================================================================================================
    // ===================================================================================================
    // request endpoint API ML  -> return array associative
    // ===================================================================================================
    // ===================================================================================================
    // $data_json={
    //     'endpoint_parent'=> 'name endPoint request',
    //     'endpointChild'=> 'name endPoint request',
    //     'body'=>  'array(key=>parm1,key=>parm2,....)', array asociativo de parametros a remplazar en la url o enviar por body al endpoit
    //     'method'=>  'get', metodo para realizar solicitud al endpoint
    //     'access_token'=> 'token', token del cliente si es requerido. si no es requeerido dejar un cadena vacia 
    // }
    public static function request_endPoint($data_json)
    {
        // $list_required_response=null;
        $endPoint = mlApi::getEndPointChild($data_json['endpoint_parent'], $data_json['endpointChild']);

        // if($endPoint['required']!='none'){
        //     $list_required_response=array();
        //     $endPoint['reqired']=explode(',',$endPoint['required']);
        //     foreach($endPoint['required'] as $key){
        //         $list_required_response[$key]=mlApi::request_endPoint(array('endpoint' => $key, 'body' => array('refresh_token' => $oApiTokenTmp->getRefresh_token()), 'method' => 'post', 'access_token' => ''));
        //     }
        // }

        // var_dump($endPoint);

        if ($endPoint != false) {
            if (array_key_exists('body', $endPoint)) {
                foreach (array_keys($endPoint['body']) as $key) {
                    if ($key == 'client_id') {
                        $endPoint['body'][$key] = mlApi::getClient_id();
                    } else if ($key == 'client_secret') {
                        $endPoint['body'][$key] = mlApi::getClient_secret();
                    } else if (array_key_exists($key, $data_json['body'])) {
                        $endPoint['body'][$key] = $data_json['body'][$key];
                    }
                }
            }
            $urltmp = $endPoint['url'];
            foreach (array_keys($data_json['body']) as $key) {
                $urltmp = str_replace($key, $data_json['body'][$key], $urltmp);
            }
            // echo '<br>';
            // echo $urltmp; 
            // echo '<br>';
            // print_r($endPoint);
            // echo '<br>';
            $endPoint['headers'] = explode(',', sprintf($endPoint['headers'], $data_json['access_token']));
            // print_r($endPoint['headers']);

            // var_dump($endPoint);
            // echo '<br>';



            $curl = curl_init($urltmp);
            curl_setopt($curl, CURLOPT_URL, $urltmp);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $endPoint['headers']);
            curl_setopt($curl, CURLOPT_HEADER, true);

            if ($endPoint['method'] == 'POST') {
                curl_setopt($curl, CURLOPT_POST, true);
            }else if ($endPoint['method'] == 'PUT') {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');           
            }else if ($endPoint['method'] == 'DELETE') {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            }

            if ($endPoint['method'] != 'GET') {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $endPoint['body']);
            }


            $response = curl_exec($curl);
            // echo '<br>';
            // var_dump($endPoint);
            curl_close($curl);
            preg_match('/\{/', $response, $match, PREG_OFFSET_CAPTURE);
            $response=json_decode(substr($response, $match[0][1]), true);
            $response['nameEndPoint']=$endPoint['name'];
            return $response;
        }

        return array('reject'=>array(
                'status' => 'fail',
                'error' => sprintf('Invalid:%s  no encontrado en %s', $data_json['endpointChild'], $data_json['endpoint_parent'])
            ),
        );
    }
}
