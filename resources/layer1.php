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
                    <div class="col-md-5" id="user">
                        <h5>Admin ML</h5>
                    </div>

                    <!-- <div class="col-md-auto offset-md-4" id='auth'> -->
                    <div class="col-md-auto offset-md-3" id='auth'>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row p-3">
    <div class="col-sm">
        <div class="card" id="body-api">

        </div>
    </div>
</div>
<div class="row p-3">
    <div class="col-sm">
        <div class="card text-white bg-warning mb-3" >
        <div class="card-header">Header</div>
        <div class="card-body">
            <h5 class="card-title">Warning card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
    </div>
</div>
</div>
< <script type="text/javascript">
    apiML('#auth').isAuth({
    // defaultMenu:true,
    scope: ['site','products', 'users']
    });
    $('body').off('click', '#authML');
    $('body').on('click', '#authML', (e) => {
    e.preventDefault();
    apiAuth('#content').redirecAuth();
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
    $('body').off('click', '#category');
    $('body').on('click', '#category', (e) => {
    e.preventDefault();
    apiML().requestEndPoint({
    EndPoint: {
    endpoint_parent: 'site',
    endpointChild: 'category',
    body:{
    category_id:'MLA572598',
    },
    },
    // urlPage: 'html/userInfo.html',
    // listIdPage: {
    // 'card-header-name': ['first_name', 'last_name'],
    // 'data-email': 'email',
    // 'data-tel': {
    // 'phone': 'number'
    // },
    // 'data-dni': {
    // 'identification': 'number'
    // },
    // 'data-dir1': {
    // 'address': 'address'
    // },
    // 'data-dir2': {
    // 'address': ['city', 'state', 'zip_code']
    // },
    // },
    });
    });
    </script>