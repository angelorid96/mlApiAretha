<?php
include "../arethafw/Aretha.php";
Aretha::init('../arethafw/conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();
date_default_timezone_set('America/Mexico_City');

$opQuestion=new \mod_questions\entities\question();
$opAnswer=new \mod_questions\entities\answer();

$opQuestion->getPO()->setIdQuestion(117642);
$opQuestion->getPO()->setSellerId(189394110);
$opQuestion->getPO()->setBuyerId(162981404);
$opQuestion->getPO()->setItemId('MLA903218023');
$opQuestion->getPO()->setStatus('ANSWERED');
$opQuestion->getPO()->setText('Texto de la pregunta.');
$opQuestion->getPO()->setDateCreated(date('c'));
$opQuestion->getPO()->setIdAnswer(10);


if($opQuestion->existIdQuestion()){
    echo 'obtener registro <br>';
    var_dump($opQuestion->selectByIdQuestion());
}else{
    echo 'no existe registro. insertar <br>';
    // var_dump($opQuestion);
    echo '<br> insertando a db <br>';
    var_dump($opQuestion->insertWithoutIdAnswer());
}

// echo '<br> update id_answer <br>';
// $opQuestion->getPO()->setId(8);
// var_dump($opQuestion->updateIdAnswer());



echo '<br> obtener todos los registros <br>';
var_dump($opQuestion->selectAll());



$opAnswer->getPO()->setId(8);
$opAnswer->getPO()->setStatus('ANSWERED');
$opAnswer->getPO()->setText('Texto de la pregunta.');
$opAnswer->getPO()->setDateCreated(date('c'));

if($opAnswer->existId()){
    echo 'obtener registro <br>';
    var_dump($opAnswer->selectById());
}else{
    echo 'no existe registro. insertar <br>';
    // var_dump($opQuestion);
    echo '<br> insertando a db <br>';
    var_dump($opAnswer->insert());
}

echo '<br> obtener todos los registros <br>';
var_dump($opAnswer->selectAll());



echo '<br> obtener todos los registros <br>';
// $opQuestion->getPO()->setId(8);
// var_dump($opQuestion->countDinam());
var_dump($opQuestion->selectDinam());



?>