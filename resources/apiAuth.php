<?php
include "../arethafw/Aretha.php";
include "../arethafw/plugins/ml/php/mlApi.class.php";
Aretha::init('../arethafw/conf/app.ini');
mlApi::init('../arethafw/plugins/ml/conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();
// Aretha::verifySession();


if (isset($_REQUEST['code']) && $_REQUEST['code'] != '') {


    // echo $_REQUEST['code'];
    $oApiToken = new \mod_apitoken\entities\apiToken();
    $response = mlApi::request_endPoint(array('endpoint_parent'=>'auth','endpointChild' => 'token', 'body' => array('code' => $_REQUEST['code']), 'method' => 'post', 'access_token' => ''));
    $response_user = mlApi::request_endPoint(array('endpoint_parent'=>'users','endpointChild' => 'userID', 'body' => array('user_id' => $response['data']['user_id']), 'method' => 'get', 'access_token' => $response['data']['access_token']));
    // echo '<br>';
    // var_dump($response);
    // echo '<br>';
    // var_dump($response_user);

    $oApiToken->getPO()->setUser_id(intval($response['data']['user_id']));
    $oApiToken->getPO()->setNickname($response_user['data']['nickname']);
    $oApiToken->getPO()->setSite_userID($response_user['data']['site_id']);
    $oApiToken->getPO()->setAcces_token($response['data']['access_token']);
    $oApiToken->getPO()->setRefresh_token($response['data']['refresh_token']);
    $oApiToken->getPO()->setDateAcces_token(date("Y-m-d H:i:s"));
    $oApiToken->getPO()->setDateRefresh_token(date("Y-m-d H:i:s"));

    $existUser = $oApiToken->existId();
    if ($existUser) {
        if($oApiToken->update()){
            // echo 'debug';
            $_SESSION['nickname']=$oApiToken->getPO()->getNickname();
            $_SESSION['user_id']=$oApiToken->getPO()->getUser_id();
            // header('Location:../');
        }
        header('Location:../');
    }
    // echo $oApiToken->insert();
    if($oApiToken->insert()){
        // echo 'debug';
        $_SESSION['nickname']=$oApiToken->getPO()->getNickname();
        $_SESSION['user_id']=$oApiToken->getPO()->getUser_id();
        // header('Location:../');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Demo ML</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" rel="stylesheet">

    <!-- Bootstrap ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Aretha  -->
    <link href="../arethafw/css/aretha.css" rel="stylesheet" type="text/css" />

    <!-- Option 1: Bootstrap Bundle with Popper  -->
    <style>
        div.dataTables_length select {
            width: 60px !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-danger navbar-dark">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link af-link" href="../" data-target="#content">ML DEMO </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row" id="content">
            <main class="bg-pattern">
                <div class="container">
                    <div class="row m-h-100">
                        <div class="col-md-8 col-lg-4  m-auto">
                            <div class="card shadow-lg p-t-20 p-b-20">
                                <div class="card-body text-center">
                                    <!-- <img width="200" alt="image" src="arethafw/img/404.svg"> -->
                                    <h1 class="display-10 fw-600 font-secondary">Autenticacion confirmada!</h1>
                                    <h6>rederigiendo automaticamente en 5 sec...</h6>
                                    <p class="opacity-75">
                                        Usuario ML:<?php echo $_SESSION['nickname']?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script type="text/javascript">

        setTimeout(() => {
            window.open('../','_self');
        }, 5000);

    </script>
    
</body>

</html>