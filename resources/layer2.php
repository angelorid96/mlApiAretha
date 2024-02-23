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
                                <a class="btn btn-primary disabled" id="predictCategoryBTN" role="button">
                                    Predecir Categorias
                                </a>
                            </div>
                            <div class="col-md-12 mb-0">
                                <div class="col-md-12 text-center h4" id="error_category" style="visibility:hidden;">
                                    El campo <strong>Titulo</strong> no se permite vacio.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="collapse" id="predictCategory">
                                    <div class="card card-body">
                                        <div class="row justify-content-md-center pb-5" id="view_category" style="visibility:hidden;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-0">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkPredictCategory">
                                    <label class="form-check-label" for="checkPredictCategory">Utilizar predictor de categoria</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row justify-content-md-cente  gx-5">
                                    <div class="col-md-6 mb-2">
                                        <label for="category_parent" class="form-label">Categoria</label>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="category_parent" class="form-label">Categoria especifica</label>
                                    </div>
                                </div>
                                <div class="row justify-content-md-cente gx-5">
                                    <div class="col-md-6">
                                        <select class="form-select form-select-lg" id="category_parent" aria-label="Default select">

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select form-select-lg" id="category_child" aria-label="Default select" disabled>

                                        </select>
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
    let view_categories = async () => {
        let categories = await apiML('#body-api').requestEndPoint({
            EndPoint: {
                endpoint_parent: 'products',
                endpointChild: 'categories',
            },
        });
        // console.log(categories);
        for (let index in categories.data) {
                // console.log(cat_pre.data[index]);
                let item = categories.data[index];
                let option_cat_item=document.createElement('option');
                option_cat_item.setAttribute('value',`${item['id']}`);
                option_cat_item.appendChild(document.createTextNode(`${item['name']}`));
                document.getElementById('category_parent').appendChild(option_cat_item);
        }
    }

    view_categories();
    $('body').off('click', '#predictCategoryBTN');
    $('body').on('click', '#predictCategoryBTN', async (e) => {
        e.preventDefault();

        let title = aretha('#title').val();
        let input_title = document.getElementById('title');

        if (title.length != 0) {
            document.getElementById('view_category').innerHTML = '';
            // console.log(encodeURIComponent(title));
            title = encodeURIComponent(title);

            let cat_pre = await apiML('#body-api').requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'products',
                    endpointChild: 'predict',
                    body: {
                        q_char: title,
                    }
                },
            });
            // console.log(cat_pre);
            for (let index in cat_pre.data) {
                console.log(cat_pre.data[index]);
                let item = cat_pre.data[index];
                let div_col = document.createElement('div');
                div_col.setAttribute('class', 'col-md-4');
                let btn_category_item = document.createElement('a');
                btn_category_item.setAttribute('class', 'btn  btn-md  border-black');
                btn_category_item.setAttribute('role', 'button');
                btn_category_item.setAttribute('id', `predict_cat${index}`);
                btn_category_item.setAttribute('category_id', item['category_id']);
                btn_category_item.setAttribute('domain_id', item['domain_id']);
                btn_category_item.appendChild(document.createTextNode(`Dominio:${item['domain_name']} > Categoria:${item['category_name']}`));
                div_col.appendChild(btn_category_item);
                document.getElementById('view_category').appendChild(div_col);
            }
            document.getElementById('view_category').style.visibility = 'visible';
            document.getElementById('predictCategory').setAttribute('class', 'collapse show')

        } else {
            document.getElementById('view_category').style.visibility = 'hidden';
            input_title.setAttribute('class', input_title.getAttribute('class') + ' border-warning');
            document.getElementById('error_category').style.visibility = 'visible';
            setTimeout(() => {
                document.getElementById('error_category').style.visibility = 'hidden';
                input_title.setAttribute('class', input_title.getAttribute('class').replace('border-warning', ''));
            }, 5000);
        }
    });
    $('body').off('click', '#checkPredictCategory');
    $('body').on('click', '#checkPredictCategory', (e) => {
        // e.preventDefault();
        let btn_predict = document.getElementById('predictCategoryBTN');
        if (e.target.checked) {
            btn_predict.setAttribute('class', btn_predict.getAttribute('class').replace('disabled', ''));
        } else {
            btn_predict.setAttribute('class', `${btn_predict.getAttribute('class')} disabled`)
            document.getElementById('view_category').innerHTML = '';
            document.getElementById('view_category').style.visibility = 'hidden';
        }
        document.getElementById('predictCategory').setAttribute('class', document.getElementById('predictCategory').getAttribute('class').replace('show', ''))
    });
    $('body').off('change', '#category_parent');
    $('body').on('change', '#category_parent', (e) => {
        // e.preventDefault();
        console.log(e);
        document.getElementById('category_child').disabled=false;
        let index_select=e.target.options.selectedIndex
        let item_select=e.target.options[index_select];
    });
</script>