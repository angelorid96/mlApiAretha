<?php
include "../arethafw/Aretha.php";
include "../arethafw/plugins/ml/php/mlApi.class.php";
include "../arethafw/plugins/ml/php/isExpireToken.php";
Aretha::init('../arethafw/conf/app.ini');
mlApi::init('../arethafw/plugins/ml/conf/app.ini');
Aretha::allErrors();
Aretha::sessionStart();

$isExpireTK = isExpiredAccessToken();
if ($isExpireTK['value']) {
};

?>
<div class="card-header text-center">
    <h3 id="card-header-name">lista de publiaciones</h3>
</div>
<div class="card-body" id="card-body-content">
    <div class="row">
        <div class="col-md-12">
            <table id="body-list-items" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="d-none">id</th>
                        <th>Imagen</th>
                        <th>Titulo</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Ver publicacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="d-none">id</th>
                        <th>Imagen</th>
                        <th>Titulo</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Ver publicacion</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    let tables = null;

    let define_dataTables = () => {


        var schema_conf_dt = "";
        schema_conf_dt += "<'row' ";
        schema_conf_dt += "<'col-12 col-md-6 mb-3'B >"; //	columns
        schema_conf_dt += "<'col-12 col-md-6'f >"; //	find	
        schema_conf_dt += "<'col-12 col-md-6'l >"; // 	length
        schema_conf_dt += ">";
        schema_conf_dt += "<'row'<'col-12't>>"; // 	table
        schema_conf_dt += "<'row'";
        schema_conf_dt += "<'col-12 col-md-12'l >"; //	length
        schema_conf_dt += "<'col-12 col-md-6'i>"; // 	information
        schema_conf_dt += "<'col-12 col-md-6'p>"; //	pagination
        schema_conf_dt += ">";

        tables = $('#body-list-items').DataTable({
            processing: true,
            serverSide: true,
            "ajax": {
                url: "resources/tableData.php",
                method: 'POST',
                data: {
                    EndPoint: {
                        endpoint_parent: 'users',
                        endpointChild: 'listItems',
                        childData: {
                            endpoint_parent: 'items',
                            endpointChild: 'view',
                        }
                    },
                },

            },
            "language": {
                "url": "arethafw/assets/plugins/datatables/language/Spanish.json",
            },
            //dom: '<"datatable-B"B><lf><t><lp><i>',                        //Esta es la configuracion por defaul del
            dom: schema_conf_dt, //aqui se invocaría la configuracion creada

            colReorder: {
                realtime: true
            },

            "order": [
                [0, "asc"]
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "orderable": false,
                    "searchable": false,
                },{
                    "targets": [1, 2, 3, 4],
                    "visible": true,
                    "orderable": true,
                    "searchable": true
                }, {
                    "targets": [5,6],
                    "visible": true,
                    "orderable": false,
                    "searchable": false,
                }, {
                    name: 'id',
                    targets: 0
                },
                {
                    name: 'thumbnail',
                    targets: 1
                },
                {
                    name: 'title',
                    targets: 2
                },
                {
                    name: 'price',
                    targets: 3
                },
                {
                    name: 'status',
                    targets: 4
                },
                {
                    name: 'permalink',
                    targets: 5
                }
                
            ],

            responsive: true,

            //responsive: {
            //	details: {
            //		type: 'column',
            //		target: 0
            //	}
            //},

            buttons: [{
                "extend": 'colvis',
                "text": 'Columnas'
            }],

            "aLengthMenu": [
                [10, 25, 100, 500],
                [10, 25, 100, 500]
            ],

            "iDisplayLength": 10,

            "search": {
                "caseInsensitive": true
            }
        });
    }

    define_dataTables();
</script>