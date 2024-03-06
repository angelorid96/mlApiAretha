<?php
include "../arethafw/Aretha.php";
Aretha::allErrors();
Aretha::sessionStart();
?>
<div class="row" id="">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto" id="user">
                        <h5>Admin ML</h5>
                    </div>
                    <!-- <div class="col-md-auto offset-md-4" id='auth'> -->
                    <div class="col-auto offset-7 p-0" id='auth'>
                        <ul class="nav" id="menu">
                            <div class="col-md-auto">
                                <li class="nav-item">
                                    <div class="dropdown" id="products"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown_products" data-bs-toggle="dropdown" aria-expanded="false">Productos</button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdown_products">
                                            <li><a class="dropdown-item" id="list_products" class-endpoint="list_products">Listar productos</a></li>
                                            <li><a class="dropdown-item" id="publish" class-endpoint="products">Publicar producto</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pt-5">
    <div class="col-md-12">
        <div class="card" id="body-api" hidden>

        </div>
    </div>
</div>
<div class="row p-3">
    <div class="col-md-12">
        <div class="card border-warning" id="card-error" hidden>
            <div class="card-header text-center h5" id="error-title">Error al llamar recuerso</div>
            <div class="card-body text-warning" id="error-body">
                <!-- <p class="card-text"></p> -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    apiML('#menu').isAuth({
        defaultMenu:true,
        // scope: ['site', 'products', 'users']
    });
    $('body').off('click', '#authML');
    $('body').on('click', '#authML', (e) => {
        e.preventDefault();
        apiML('#content').redirecAuth();
    });
    $('body').off('click', '#userID');
    $('body').on('click', '#userID', (e) => {
        e.preventDefault();
        apiML('#body-api').requestEndPoint({
            EndPoint: {
                endpoint_parent: 'users',
                endpointChild: 'userID',
            },
            urlPage: 'html/userInfo.html',
            listIdPage: {
                'card-header-name': ['first_name', 'last_name'],
                'data-email': 'email',
                'data-tel': {
                    'phone': 'number'
                },
                'data-dni': {
                    'identification': 'number'
                },
                'data-dir1': {
                    'address': 'address'
                },
                'data-dir2': {
                    'address': ['city', 'state', 'zip_code']
                },
            },
        });
    });
    $('body').off('click', '#publish');
    $('body').on('click', '#publish', (e) => {
        e.preventDefault();
        apiML().post({},'resources/layer2.php','#body-api',true);
        document.getElementById('body-api').hidden=false;
        // apiML('#body-api').requestEndPoint({
        //     EndPoint: {
        //         endpoint_parent: 'users',
        //         endpointChild: 'userID',
        //     },
        //     urlPage: 'html/userInfo.html',
        //     listIdPage: {
        //         'card-header-name': ['first_name', 'last_name'],
        //         'data-email': 'email',
        //         'data-tel': {
        //             'phone': 'number'
        //         },
        //         'data-dni': {
        //             'identification': 'number'
        //         },
        //         'data-dir1': {
        //             'address': 'address'
        //         },
        //         'data-dir2': {
        //             'address': ['city', 'state', 'zip_code']
        //         },
        //     },
        // });
    });
    
    
</script>