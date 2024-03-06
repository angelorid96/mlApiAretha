<?php
include "../arethafw/Aretha.php";
include "../arethafw/plugins/ml/php/mlApi.class.php";
Aretha::init('../arethafw/conf/app.ini');
mlApi::init('../arethafw/plugins/ml/conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();

$tmp_json = json_decode(file_get_contents('php://input'), true);

if ($tmp_json != null) {
    $file_json=json_decode(file_get_contents('log.json'), true);

    var_dump($file_json);
    echo '<br>';
    var_dump($tmp_json);

    file_put_contents('log.json',json_encode($tmp_json));
}


?>