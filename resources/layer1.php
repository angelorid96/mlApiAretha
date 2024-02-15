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
                    <div class="col-md-6" id="user">
                        <h5>Admin ML</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end" id='auth'>
                          
                        </div>
                    </div>
                    <div class="col-md-auto" id="notf">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    apiAuth('#auth').isAuth({html:'<div class="dropdown">'+
  '<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="" data-bs-toggle="dropdown" aria-expanded="false">'+
    'Dropdown link'+
  '</a>'+
  '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">'+
  '<li><a class="dropdown-item" href="#">Action</a></li>'+
    '<li><a class="dropdown-item" href="#">Another action</a></li>'+
    '<li><a class="dropdown-item" href="#">Something else here</a></li>'+
    '</ul>'+
    '</div>'
    });
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