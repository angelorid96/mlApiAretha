<?php
include "../arethafw/Aretha.php";
include "../arethafw/plugins/ml/php/mlApi.class.php";
include "../arethafw/plugins/ml/php/isExpireToken.php";

mlApi::init('../arethafw/plugins/ml/conf/app.ini');
Aretha::init('../arethafw/conf/app.ini');

Aretha::allErrors();
Aretha::sessionStart();

$isExpireTK = isExpiredAccessToken();
if ($isExpireTK['value']) {
}

?>
<div class="card-header text-center">
    <h3 id="card-header-name">Publicar producto</h3>
</div>
<div class="card-body" id="card-body-content">
    <div class="accordion row" id="accordionProducto">
        <div class="accordion-item col-md-12">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" id="create_publish" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Creacion de publicacion { Titulo y Atributos }
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" id="create_publish_body" aria-labelledby="headingOne" data-bs-parent="#accordionProducto">
                <div class="accordion-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6 offset-md-3">
                                <label for="title" class="form-label">Titulo</label>
                            </div>
                            <div class="col-md-6  offset-md-3 mt-0">
                                <input type="text" class="form-control" aria-describedby="titlePubilish" id="title">
                                <div id="titlePubilish" class="form-text">
                                    Recomendaciones para el titulo Producto + Marca + modelo del producto + etc.
                                </div>
                            </div>
                            <div class="col-md-3 mt-0">
                                <a class="btn btn-primary" id="predictCategoryBTN" role="button">
                                    Predecir Categorias
                                </a>
                            </div>
                            <div class="col-md-12">
                                <div class="collapse " id="predictCategory">
                                    <div class="card card-body">
                                        <div class="row justify-content-md-center">
                                            <div class="col col-md-2">
                                                <a class="btn  btn-lg" role="button" id="predict_cat1">
                                                    Categoria 1
                                                </a>
                                            </div>
                                            <div class="col col-md-2">
                                                <a class="btn  btn-lg" role="button" id="predict_cat2">
                                                    Categoria 2
                                                </a>
                                            </div>
                                            <div class="col col-md-2">
                                                <a class="btn  btn-lg" role="button" id="predict_cat3">
                                                    Categoria 3
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('body').off('click', '#predictCategoryBTN');
    $('body').on('click', '#predictCategoryBTN', (e) => {
        e.preventDefault();

        let title = aretha('#title').val();
        let input_title = document.getElementById('title');

        if (title.length != 0) {
            input_title.setAttribute('class', input_title.getAttribute('class').replace('border-warning', ''));
            title = title.replaceAll(' ', '%20')
            console.log(title);
            let cat_pre = apiML('#body-api').requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'products',
                    endpointChild: 'predict',
                    body: {
                        q_char: title,
                    }
                },
            });
            console.log(cat_pre);
        } else {
            input_title.setAttribute('class', input_title.getAttribute('class') + ' border-warning');
        }
    });
</script>