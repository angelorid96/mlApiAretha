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

                    <div class="col-md-auto" id='auth'>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    apiAuth('#auth').isAuth({
        scope: ['site', 'q&a', 'shipping', 'products', 'users']
    });
    $('body').off('click', '#authML');
    $('body').on('click', '#authML', (e) => {
        e.preventDefault();
        apiAuth('#content').redirecAuth();
    });
    $('body').off('click', '#userID');
    $('body').on('click', '#userID', (e) => {
        e.preventDefault();
        apiAuth('#content').requestEndPoint({
            EndPoint:{
                endpoint_parent: 'users',
                endpointChild: 'userID',
            },
            urlPage:'html/userInfo.html',
            listIdPage:{
                'card-header-name':['first_name','last_name'],
                'data-email':'email',
            },
        });
    });
</script>