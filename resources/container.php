<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ejemplo Contenedor Ajax</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" rel="stylesheet">

    <!-- Bootstrap ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- DataTables  -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables  Local Files-->
    <!-- <link href="DataTables/DataTables-1.13.8/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="DataTables/Bootstrap-5-5.3.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="DataTables/Responsive-2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css">
        <link href="DataTables/FixedColumns-4.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.css" rel="stylesheet"  type="text/css"> -->

    <!-- Aretha  -->
    <link href="arethafw/css/aretha.css" rel="stylesheet" type="text/css" />

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
                        <a class="nav-link af-link" href="resources/layer1.php" data-target="#content">API ML</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row" id="content">

        </div>
        <div class="row">
            <div class="row p-3">
                <div class="col-md-12">
                    <div class="card border-warning" id="card-error" hidden>
                        <div class="card-header text-center h5" id="error-title">Error al llamar recuerso</div>
                        <div class="card-body" id="error-body">
                            <!-- <p class="card-text"></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="toast-container position-static" id="container-toast">
            
            </div>
        </div>
    </div>

    <!-- Sweet Alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JQuery  -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


    <!-- JQuery  Local Files-->
    <!-- <script src="DataTables/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script src="DataTables/Bootstrap-5-5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="DataTables/Responsive-2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="DataTables/Responsive-2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="DataTables/FixedColumns-4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="DataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.js"></script> -->


    <!-- Aretha  -->
    <script src="arethafw/js/aretha.js"></script>
    <script src="arethafw/plugins/ml\js/toolsApiML.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <!-- JavaScript  -->
    <script src="js/global.js"></script>

</body>

</html>