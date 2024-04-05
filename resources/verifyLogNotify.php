<?php
include "../arethafw/Aretha.php";
include "../arethafw/plugins/ml/php/mlApi.class.php";
include "../arethafw/plugins/ml/php/isExpireToken.php";
Aretha::init('../arethafw/conf/app.ini');
mlApi::init('../arethafw/plugins/ml/conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();


$array_nofi=json_decode(file_get_contents('request.json'),true);
if($array_nofi!=null){

    // file_put_contents('request.json','[]');
    $offset=$array_nofi['offset'];
    $tmp_noti=array_slice($array_nofi['notis'],$offset);
    $offset=count($array_nofi['notis']);
    $array_nofi=json_decode(file_get_contents('request.json'),true);
    $array_nofi['offset']=$offset;
    file_put_contents('request.json', json_encode($array_nofi));
    echo json_encode($array_nofi);
}
?>