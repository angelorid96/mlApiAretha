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
    apiAuth('#auth').isAuth({scope:['site','q&a','shipping','products','users']});
    $('body').off('click', '#authML');
    $('body').on('click', '#authML', (e) => {
        e.preventDefault();
        apiAuth('#content').redirecAuth();
        // aretha().get({
        // 			"url":"resources/apiAuth.php",
        // 			"data":`State=${$('#authML').val()}`,
        // 			"useNotFoundPage": true,
        // 			"notFoundPage": 'arethafw/html/404.html',
        // 			success: function (data) {
        //                 const response=JSON.parse(data);
        //                 if(response.State=='redic'){
        //                     // console.log(response.url);
        //                     window.open(response.url,'_self');
        //                 }else{

        //                 }
        //                 // console.log();
        // 			},
        // 			notfound: function (xhr) {
        // 				aretha('#content').html(xhr);
        // 			}
        // 		});
    });
</script>