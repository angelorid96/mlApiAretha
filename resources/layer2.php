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
        <div class="accordion-item col-md-12 pb-2">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" id="create_publish" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Creacion de publicacion
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" id="create_publish_body" aria-labelledby="headingOne" data-bs-parent="#accordionProducto">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-md-6 offset-md-3">
                            <label for="title" class="form-label">Titulo</label>
                        </div>
                        <div class="col-md-6  offset-md-3 mt-0">
                            <input type="text" class="form-control apiML-param" value-type="string" aria-describedby="titlePubilish" id="title">
                            <div id="titlePubilish" class="form-text">
                                Recomendaciones para el titulo Producto + Marca + modelo del producto + etc.
                            </div>
                        </div>
                        <div class="col-md-3 mt-0">
                            <button class="btn btn-primary" id="predictCategoryBTN" disabled>
                                Predecir Categorias
                            </button>
                        </div>
                        <div class="col-md-12 mb-0">
                            <div class="col-md-12 text-center h4" id="error_category" hidden>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="collapse" id="predictCategory">
                                <div class="card card-body">
                                    <div class="row justify-content-md-center pb-2" id="view_category" hidden>
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
                            <div class="row justify-content-md-center gx-1">
                                <div class="col-md-5 mb-2 ms-1">
                                    <label for="category_parent" class="form-label">Categoria</label>
                                    <select class="form-select " id="category_parent" aria-label="Default select">

                                    </select>
                                </div>
                                <div class="col-md-5 mb-2 ms-1">
                                    <label for="category_child1" class="form-label">Categoria especifica</label>
                                    <select class="form-select " id="category_child1" aria-label="Default select" disabled>

                                    </select>
                                </div>
                                <div class="col-md-12 mb-2 ms-1">
                                    <div class="row justify-content-md-center gx-1 mt-2" id="childs_category">

                                    </div>
                                </div>
                                <div class="col d-none">
                                    <input type="text" class="form-control apiML-param apiML-shipp" id="category_id" value-type="text" hidden>
                                    <input type="text" class="form-control" id="domain_id" value-type="text" hidden>
                                </div>
                                <div class="col-md-3 mb-2 ms-1" id>
                                    <label for="price" class="form-label">Precio</label>
                                    <div class="input-group ">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control apiML-param" id="price" value-type="number" aria-label="Amount (to the nearest dollar)">
                                        <select class="form-select apiML-param" id="currency_id" value-type="text" aria-label="Default select example">
                                            <option value="MXN">MXN</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="condition" class="form-label">Estado del producto</label>
                                    <select class="form-select apiML-param" id="ITEM_CONDITION" id-endpoint="attributes" select-sndata="all" type-endpoint="list" value-type="string" tag-var="attr" type-struct="object" aria-label="Default select example">
                                        <option value="none">...</option>
                                        <option value="2230284">Nuevo</option>
                                        <option value="2230581">Usado</option>
                                        <option value="2230582">Reacondicionado</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="condition" class="form-label">Cantidad disponible</label>
                                    <input type="text" class="form-control apiML-param" id="available_quantity" value-type="number" aria-label="catidad disponible">
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="condition" class="form-label">Tipo de publicacion</label>
                                    <select class="form-select apiML-param" id="listing_type_id" select-sndata="value" value-type="string" aria-label="Default select example">
                                        <option value="none">...</option>
                                        <option value="gold_pro">Premium</option>
                                        <option value="gold_special">Clásica</option>
                                        <option value="free">Gratuita</option>
                                    </select>
                                </div>
                                <div class="col-md-3  ms-2 mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input apiML-param" type="radio" name="flexRadioDisabled" id-endpoint="tags" type-endpoint="list" value-type="string" value="immediate_payment" checked disabled>
                                        <label class="form-check-label" for="flexRadioCheckedDisabled">
                                            Modalidad de compra inmediata
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="condition" class="form-label">Tipo de garantia</label>
                                    <select class="form-select apiML-param" id="WARRANTY_TYPE" id-endpoint="sale_terms" select-sndata="value" type-endpoint="list" value-type="string" tag-var="attr" type-struct="object" aria-label="Default select example">
                                        <option value="none">...</option>
                                        <option value="2230279">Garantia de fabrica</option>
                                        <option value="2230280">Garantia del vendedor</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="price" class="form-label">Tiempo de garantia</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control apiML-param" id="WARRANTY_TIME" need-unit select-sndata="all" id-endpoint="sale_terms" type-endpoint="list" value-type="string" tag-var="attr" type-struct="object" aria-label="Amount (to the nearest dollar)">
                                        <select class="form-select" id="WARRANTY_TIME_unit" aria-label="Default select example">
                                            <option value="none">...</option>
                                            <option value="dias">dias</option>
                                            <option value="meses">meses</option>
                                            <option value="años">años</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2 ms-5">
                                    <label for="condition" class="form-label">Canal de publicacion</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input apiML-param" type="checkbox" id-endpoint="channels" type-endpoint="list" value-type="string" id="marketplace_check" value="marketplace">
                                        <label class="form-check-label" for="marketplace_check">Mercado Libre</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input apiML-param" type="checkbox" id="mshops_check" id-endpoint="channels" type-endpoint="list" value-type="string" value="mshops">
                                        <label class="form-check-label" for="mshops_check">Mercado Shop</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2 pt-2">
                                    <a class="btn btn-primary" id="category-confirm" role="button" aria-disabled="true">
                                        confirmar categoria
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item col-md-12 pb-2">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" id="create_attributes" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    Definir atributos
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" id="create_attributes_body" aria-labelledby="headingTwo" data-bs-parent="#accordionProducto">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-4  align-self-start">
                            <div class="input-group mb-3">
                                <select class="form-select" id="attributes_add" aria-label="Default select example">
                                    <option value="none" selected>atributos</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="button" id="add_attr_btn">Agregar</button>
                                <button class="btn btn-outline-secondary" type="button" id="remove_attr_btn">Eliminar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3" id="view_attr">

                    </div>
                    <div class="row g-3 mt-2 justify-content-md-center">
                        <div class="col-md-12 mb-2 ms-1">
                            <p class="h3 text-center">Imagenes</p>
                        </div>
                        <div class="col-md-4 ">
                            <label for="formFileMultiple" class="form-label">Seleccione fuente imagen</label>
                            <div class="input-group mb-3">
                                <select class="form-select" id="img_add" aria-label="Default select example">
                                    <option value="url">url</option>
                                    <option value="none" disabled>id mercado libre</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="button" id="add_img_btn">Agregar</button>
                            </div>

                        </div>
                        <div class="col-md-6 mb-2 ms-1">
                            <label for="formFileMultiple" class="form-label">Seleccione archivos</label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="file" id="formFileMultiple" multiple>
                                <button class="btn btn-outline-secondary" type="button" id="upload_img_btn">subir</button>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2" id="img_input">

                    </div>
                    <div class="row g-3 mt-2 justify-content-md-center">
                        <div class="col-md-12 mb-2 ms-1">
                            <p class="h3 text-center">Variaciones</p>
                        </div>
                        <div class="card col-md-12">
                            <div class="card-header text-center col-md-12">
                                <div class="row justify-content-md-center">
                                    <div class="col-md-8 text-center"><span class="h4">Marque atributos que tendran variacion </span></div>
                                    <div class="col-md-2 align-self-end"> <button class="btn btn-outline-secondary" type="button" id="add_attr_var_btn">agregar variacion</button></div>
                                </div>
                            </div>
                            <div class="card-body text-center col-md-12">
                                <div class="row g-3 mt-3" id="attr_var">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2" id="attr_var_view">

                    </div>
                    <div class="row g-3 mt-2" id="panel_grid" hidden>
                        <div class="col-md-12 mb-2 ms-1">
                            <p class="h3 text-center">Guia de tallas</p>
                        </div>
                        <div class="col-md-12">
                            <div class="row justify-content-md-start">
                                <div class="col-md-2">
                                    <button class="btn btn-outline-secondary" type="button" id="get_attr_grid_layout">Consultar atributos</button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-outline-secondary" type="button" id="add_attr_grid_layout">Crear guia de tallas perzsonalizada</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2" id="panel_grip_view">

                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item col-md-12 pb-2">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" id="shipp_attrs" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    Envio
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" id="shipp_body" aria-labelledby="headingThree" data-bs-parent="#accordionProducto">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-4  align-self-start">
                            <button class="btn btn-outline-secondary" type="button" id="get_shipp_mode">Consultar metodos envio</button>
                        </div>
                    </div>
                    <div class="row g-3 mt-2 justify-content-md-center">
                        <div class="col-md-12 mb-2 ms-1 text-center">
                            <p class="h6">Establesca el metodo de envio. de acuerdo a sus opciones permitidas</p>
                        </div>
                        <div class="col-md-2 mb-2 ms-1">
                            <label for="condition" class="form-label">Modalidad de envio</label>
                            <select class="form-select apiML-param" id="mode_shipp" id-endpoint="shipping" type-endpoint="object" value-type="string" tag-var="mode|type" multi-val="true">

                            </select>
                        </div>
                        <div class="col-md-2 mb-2 ms-5">
                            <div class="form-check form-switch">
                                <input class="form-check-input apiML-param" type="checkbox" id="free_ship_check" vlaue="true" id-endpoint="shipping" type-endpoint="object" value-type="boolean" tag-var="free_shipping">
                                <label class="form-check-label" for="free_ship_check">Envio gratis</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-md-center">
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary" type="button" id="val_publish">Validar publicacion</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary" type="button" id="publish_send">Publicar producto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item col-md-12 pb-2">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" id="descrintion_add" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                    Descripción de la publicacion
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" id="descrintion_body" aria-labelledby="headingFour" data-bs-parent="#accordionProducto">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col d-none">
                            <input type="text" class="form-control" id="item_id" hidden>
                        </div>
                        <div class="col-md-12 text-center">
                            <p class="h4">solo se permite introducir texto plano</p>
                        </div>
                    </div>
                    <div class="row mb-5 mt-2">
                        <div class="col-md-12 text-center">
                            <!-- <label for="validationTextarea" class="form-label">Descripción</label> -->
                            <textarea class="form-control apiML-dp" id="plain_text" value-type="string"></textarea>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-md-center">
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary" type="button" id="description_add">Agregar descripción</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const max_nuber_images = 12;
    const max_nuber_images_var = 10;
    const max_description_length = 50000;
    let count_images_add = 0;
    let count_variations_add = 0;
    let imgs_vars = {};
    let domain_id_value = '';
    let tmp_prev_elem = null;

    let list_attr_vars = [];

    let select_variation_attr = document.createElement('select');
    select_variation_attr.setAttribute('class', 'form-select');
    select_variation_attr.setAttribute('id', 'select_var_attr_item');


    let view_categories = async () => {
        let categories = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'site',
                endpointChild: 'categories',
            },
        });
        // console.log(categories);
        let option_cat_item = document.createElement('option');
        option_cat_item.setAttribute('value', 'none');
        option_cat_item.appendChild(document.createTextNode('seleccione categoria'));
        document.getElementById('category_parent').appendChild(option_cat_item);
        for (let index in categories.data) {
            // console.log(cat_pre.data[index]);
            let item = categories.data[index];
            option_cat_item = document.createElement('option');
            option_cat_item.setAttribute('value', `${item['id']}`);
            option_cat_item.appendChild(document.createTextNode(`${item['name']}`));
            document.getElementById('category_parent').appendChild(option_cat_item);
        }
    }
    let view_pref_shipp = async () => {


        // let option_mode_ship = document.createElement('option');
        // option_mode_ship.setAttribute('value', 'none');
        // option_mode_ship.appendChild(document.createTextNode('modos'));
        // document.getElementById('mode_shipp').appendChild(option_mode_ship);
        // for (let index = 0; index < pref_ship.data.logistics.length; index++) {

        //     let item = pref_ship.data.logistics[index];
        //     // console.log(item);
        //     option_mode_ship = document.createElement('option');
        //     option_mode_ship.setAttribute('value', `${item['mode']}`);
        //     option_mode_ship.appendChild(document.createTextNode(`${item['mode']}`));
        //     document.getElementById('mode_shipp').appendChild(option_mode_ship);
        // }
    }

    /*
        args -> array de objetos que contiene 
            target -> identificador del elemeto a manipular
            msg -> mensaje a isertar en el elemento target
            btstyle -> estilo bootstrap que le quiere dar al elemento target
            action -> accion que desea ralizar sobre el elemento target
         ejemplo. [{target:"error_category",msg:"El campo <strong>Titulo</strong> no se permite vacio.",btstyle:"border-warning",action:"hidden"}...]
    */
    let show_error_element = (args, time_view = 5000) => {

        args.forEach((item) => {
            // console.log(item);
            let select_elm;
            if (item.target.charAt(0) == '.') {
                select_elm = document.querySelector(item.target);
            } else if (item.target.charAt(0) == '#') {
                select_elm = document.getElementById(item.target.replace('#', ''));
            } else {
                select_elm = document.getElementById(item.target);
            }
            select_elm.classList.add(item.btstyle);
            select_elm.innerHTML = item.msg;
            switch (item.action) {
                case 'hidden':
                    select_elm.hidden = false;
                    break;
                case 'disabled':
                    select_elm.disabled = false;
                    break;
            }
            setTimeout(() => {
                select_elm.classList.remove(item.btstyle);
                select_elm.innerHTML = '';
                switch (item.action) {
                    case 'hidden':
                        select_elm.hidden = true;
                        break;
                    case 'disabled':
                        select_elm.disabled = true;
                        break;
                }
            }, time_view);

        });
    }

    view_categories();
    // view_pref_shipp();
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
                    endpoint_parent: 'site',
                    endpointChild: 'predict',
                    body: {
                        q: title,
                    }
                },
            });
            // console.log(cat_pre);
            for (let index in cat_pre.data) {
                // console.log(cat_pre.data[index]);
                let item = cat_pre.data[index];
                let div_col = document.createElement('div');
                div_col.setAttribute('class', 'col-md-4');
                let btn_category_item = document.createElement('a');
                btn_category_item.setAttribute('class', 'btn  btn-md  border-black');
                btn_category_item.setAttribute('role', 'button');
                // btn_category_item.setAttribute('id', `predict_cat${index}`);
                btn_category_item.setAttribute('id', 'predict_cat');
                btn_category_item.setAttribute('category_id', item['category_id']);
                btn_category_item.setAttribute('domain_id', item['domain_id']);
                btn_category_item.appendChild(document.createTextNode(`Dominio:${item['domain_name']} > Categoria:${item['category_name']}`));
                div_col.appendChild(btn_category_item);
                document.getElementById('view_category').appendChild(div_col);
            }
            document.getElementById('view_category').hidden = false;
            aretha('#predictCategory').addClass('show');

        } else {
            show_error_element([{
                target: "error_category",
                msg: "El campo <strong>Titulo</strong> no se permite vacio.",
                btstyle: "border-warning",
                action: "hidden"
            }]);
        }
    });
    $('body').off('click', '#checkPredictCategory');
    $('body').on('click', '#checkPredictCategory', (e) => {
        // e.preventDefault();

        if (e.target.checked) {
            document.getElementById('predictCategoryBTN').disabled = false;
            document.getElementById('category_parent').disabled = true;
            document.getElementById('category_child1').disabled = true;
            document.getElementById('childs_category').innerHTML = '';
        } else {
            document.getElementById('predictCategoryBTN').disabled = true;
            document.getElementById('view_category').innerHTML = '';
            document.getElementById('view_category').hidden = true;
            document.getElementById('category_parent').disabled = false;
            document.getElementById('childs_category').innerHTML = '';
            document.getElementById('category_child1').innerHTML = '';
            document.getElementById('category_parent').selectedIndex = 0;
            aretha('#predictCategory').removeClass('show');
        }

    });
    $('body').off('click', '#predict_cat');
    $('body').on('click', '#predict_cat', async (e) => {
        e.preventDefault();

        let category = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'categories',
                endpointChild: 'category',
                body: {
                    category_id: aretha().targetize(e).getAttribute('category_id'),
                }
            },
        });

        console.log(aretha().targetize(e).getAttribute('category_id'));
        // console.log(aretha().targetize(e).getAttribute('category_id'));
        document.getElementById('category_id').setAttribute('value', aretha().targetize(e).getAttribute('category_id'));
        document.getElementById('domain_id').setAttribute('value', aretha().targetize(e).getAttribute('domain_id'));

        let max_length_title = category.data.settings.max_title_length;
        let title = document.getElementById('title');
        title.setAttribute('maxlength', `${max_length_title}`);
        document.getElementById('childs_category').innerHTML = '';
        if (category.data.path_from_root.length > 0) {
            for (let index in category.data.path_from_root) {
                // console.log(category.data.path_from_root[index]);
                if (index == 0) {
                    let select_parent = document.getElementById('category_parent');
                    let index_select_new = 0;
                    // console.log(select_parent);
                    for (let option = 0; option <= (select_parent.options.length) - 2; option++) {
                        // console.log(select_parent[option].value);
                        if (select_parent[option].value == category.data.path_from_root[index].id) {
                            index_select_new = option;
                            break;
                        }
                    }
                    select_parent.selectedIndex = index_select_new;
                } else if (index == 1) {
                    document.getElementById('category_child1').innerHTML = '';
                    let option_cat_item = document.createElement('option');
                    option_cat_item.selected = true;
                    option_cat_item.setAttribute('value', category.data.path_from_root[index].id);
                    option_cat_item.appendChild(document.createTextNode(category.data.path_from_root[index].name));
                    document.getElementById('category_child1').appendChild(option_cat_item);
                } else {

                    let div_col = document.createElement('div');
                    div_col.setAttribute('class', 'col-md-3 mb-2 ms-1');
                    let label_childs = document.createElement('label');
                    label_childs.setAttribute('for', 'category_childs');
                    label_childs.setAttribute('class', 'form-label');
                    label_childs.appendChild(document.createTextNode('Refinar'));
                    let select_childs = document.createElement('select');
                    select_childs.setAttribute('class', 'form-select')
                    select_childs.setAttribute('aria-label', 'Default select')
                    select_childs.disabled = true;
                    // select_childs.setAttribute('id', 'category_childs');
                    let option_cat_item = document.createElement('option');
                    option_cat_item.selected = true;
                    option_cat_item.setAttribute('value', category.data.path_from_root[index].id);
                    option_cat_item.appendChild(document.createTextNode(category.data.path_from_root[index].name));
                    select_childs.appendChild(option_cat_item);
                    div_col.appendChild(label_childs);
                    div_col.appendChild(select_childs);
                    document.getElementById('childs_category').appendChild(div_col);
                }
            }
        } else {
            let select_parent = document.getElementById('category_parent');
            let index_select_new = 0;
            // console.log(select_parent);
            for (let option = 0; option <= (select_parent.options.length) - 2; option++) {
                // console.log(select_parent[option].value);
                if (select_parent[option].value == category.data.id) {
                    index_select_new = option;
                    break;
                }
            }
            select_parent.selectedIndex = index_select_new;
        }
        // document.getElementById('view_category').innerHTML = '';
        // document.getElementById('view_category').hidden=true;


    });
    $('body').off('change', '#category_parent');
    $('body').on('change', '#category_parent', async (e) => {
        // e.preventDefault();
        document.getElementById('category_child1').disabled = false;
        let select_parent = aretha().targetize(e);
        let item_select = select_parent.options[select_parent.selectedIndex];
        // console.log(item_select.value);
        if (item_select.value != 'none') {
            let category = await apiML('#body-api').requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'categories',
                    endpointChild: 'category',
                    body: {
                        category_id: item_select.value,
                    }
                },
            });
            document.getElementById('category_id').setAttribute('value', item_select.value);
            document.getElementById('domain_id').setAttribute('value', category.data.settings.catalog_domain);
            let max_length_title = category.data.settings.max_title_length;
            let title = document.getElementById('title');
            title.setAttribute('maxlength', `${max_length_title}`);
            // console.log(title.value);
            if (title.value.length > max_length_title) {
                show_error_element([{
                    target: "error_category",
                    msg: `Esta categoria solo acepta ${max_length_title} caracteres.`,
                    btstyle: "border-warning",
                    action: "hidden"
                }]);
                // document.getElementById('error_category').style.visibility = 'visible';
                // document.getElementById('error_category').appendChild(document.createTextNode(`Esta categoria solo acepta ${max_length_title} caracteres.`));
            }
            document.getElementById('category_child1').innerHTML = '';
            document.getElementById('childs_category').innerHTML = '';
            let option_cat_item = document.createElement('option');
            option_cat_item.selected = true;
            option_cat_item.setAttribute('value', 'none');
            option_cat_item.appendChild(document.createTextNode('Seleccione una sub categoria'));
            document.getElementById('category_child1').appendChild(option_cat_item);
            for (let index in category.data.children_categories) {
                // console.log(cat_pre.data[index]);
                let item = category.data.children_categories[index];
                option_cat_item = document.createElement('option');
                option_cat_item.setAttribute('value', `${item['id']}`);
                option_cat_item.appendChild(document.createTextNode(`${item['name']}`));
                document.getElementById('category_child1').appendChild(option_cat_item);
            }

        } else {
            document.getElementById('category_child1').innerHTML = '';
            document.getElementById('category_child1').disabled = true;
            document.getElementById('childs_category').innerHTML = '';
        }

    });
    $('body').off('change', '#category_child1');
    $('body').on('change', '#category_child1', async (e) => {
        e.preventDefault();
        // console.log(e);
        let select_child = aretha().targetize(e);
        // console.log(select_child)
        let item_select = select_child.options[select_child.selectedIndex];
        // console.log(item_select.value);
        if (item_select.value != 'none') {
            let category = await apiML('#body-api').requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'categories',
                    endpointChild: 'category',
                    body: {
                        category_id: item_select.value,
                    }
                },
            });
            // console.log(category.data);
            document.getElementById('category_id').setAttribute('value', item_select.value);
            document.getElementById('domain_id').setAttribute('value', category.data.settings.catalog_domain);
            let max_length_title = category.data.settings.max_title_length;
            let title = document.getElementById('title');
            title.setAttribute('maxlength', `${max_length_title}`);
            // console.log(title.value);
            if (title.value.length > max_length_title) {
                show_error_element([{
                    target: "error_category",
                    msg: `Esta categoria solo acepta ${max_length_title} caracteres.`,
                    btstyle: "border-warning",
                    action: "hidden"
                }]);
            }
            document.getElementById('childs_category').innerHTML = '';
            if (category.data.children_categories.length > 0) {
                let div_col = document.createElement('div');
                div_col.setAttribute('class', 'col-md-3 mb-2 ms-1');
                let label_childs = document.createElement('label');
                label_childs.setAttribute('for', 'category_childs');
                label_childs.setAttribute('class', 'form-label');
                label_childs.appendChild(document.createTextNode('Refinar'));
                let select_childs = document.createElement('select');
                select_childs.setAttribute('class', 'form-select')
                select_childs.setAttribute('aria-label', 'Default select')
                select_childs.setAttribute('id', 'category_childs')
                let option_cat_item = document.createElement('option');
                option_cat_item.selected = true;
                option_cat_item.setAttribute('value', 'none');
                option_cat_item.appendChild(document.createTextNode('Seleccione una sub categoria'));
                select_childs.appendChild(option_cat_item);
                for (let index in category.data.children_categories) {
                    // console.log(cat_pre.data[index]);
                    let item = category.data.children_categories[index];
                    option_cat_item = document.createElement('option');
                    option_cat_item.setAttribute('value', `${item['id']}`);
                    option_cat_item.appendChild(document.createTextNode(`${item['name']}`));
                    select_childs.appendChild(option_cat_item);
                }
                div_col.appendChild(label_childs);
                div_col.appendChild(select_childs);
                document.getElementById('childs_category').appendChild(div_col);
            }
        } else {
            document.getElementById('childs_category').innerHTML = '';
        }

    });
    $('body').off('change', '#category_childs');
    $('body').on('change', '#category_childs', async (e) => {
        e.preventDefault();
        // console.log(e);
        let select_child = aretha().targetize(e);
        // console.log(select_child);
        let item_select = select_child.options[select_child.selectedIndex];
        // console.log(item_select.value);
        if (item_select.value != 'none') {
            let category = await apiML('#body-api').requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'categories',
                    endpointChild: 'category',
                    body: {
                        category_id: item_select.value,
                    }
                },
            });
            // console.log(category.data);
            document.getElementById('category_id').setAttribute('value', item_select.value);
            document.getElementById('domain_id').setAttribute('value', category.data.settings.catalog_domain);
            let max_length_title = category.data.settings.max_title_length;
            let title = document.getElementById('title');
            title.setAttribute('maxlength', `${max_length_title}`);
            // console.log(title.value);
            if (title.value.length > max_length_title) {
                show_error_element([{
                    target: "error_category",
                    msg: `Esta categoria solo acepta ${max_length_title} caracteres.`,
                    btstyle: "border-warning",
                    action: "hidden"
                }]);
            }

            while (select_child.parentElement.nextElementSibling != null) {
                select_child.parentElement.nextElementSibling.remove();
            }

            if (category.data.children_categories.length > 0) {
                let div_col = document.createElement('div');
                div_col.setAttribute('class', 'col-md-3 mb-2 ms-1');
                let label_childs = document.createElement('label');
                label_childs.setAttribute('for', 'category_childs');
                label_childs.setAttribute('class', 'form-label');
                label_childs.appendChild(document.createTextNode('Refinar'));
                let select_childs = document.createElement('select');
                select_childs.setAttribute('class', 'form-select')
                select_childs.setAttribute('aria-label', 'Default select')
                select_childs.setAttribute('id', 'category_childs');
                let option_cat_item = document.createElement('option');
                option_cat_item.selected = true;
                option_cat_item.setAttribute('value', 'none');
                option_cat_item.appendChild(document.createTextNode('Seleccione una sub categoria'));
                select_childs.appendChild(option_cat_item);
                for (let index in category.data.children_categories) {
                    // console.log(cat_pre.data[index]);
                    let item = category.data.children_categories[index];
                    option_cat_item = document.createElement('option');
                    option_cat_item.setAttribute('value', `${item['id']}`);
                    option_cat_item.appendChild(document.createTextNode(`${item['name']}`));
                    select_childs.appendChild(option_cat_item);
                }
                div_col.appendChild(label_childs);
                div_col.appendChild(select_childs);
                document.getElementById('childs_category').appendChild(div_col);
            }
        } else {
            while (select_child.parentElement.nextElementSibling != null) {
                select_child.parentElement.nextElementSibling.remove();
            }
        }

    });
    $('body').off('click', '#add_attr_btn');
    $('body').on('click', '#add_attr_btn', (e) => {
        e.preventDefault();
        let select_child = document.getElementById('attributes_add');
        let id_elem = select_child.options[select_child.selectedIndex].value;
        let div_col = document.getElementById(`${id_elem}`);
        div_col.hidden = false;
        let item = div_col.querySelector('[id="input-attr"]');
        item.classList.add('apiML-param');


    });
    $('body').off('click', '#remove_attr_btn');
    $('body').on('click', '#remove_attr_btn', (e) => {
        e.preventDefault();
        let select_child = document.getElementById('attributes_add');
        let id_elem = select_child.options[select_child.selectedIndex].value;
        let div_col = document.getElementById(`${id_elem}`);
        div_col.hidden = true;
        let item = div_col.querySelector('[id="input-attr"]');
        item.classList.remove('apiML-param');


    });
    $('body').off('click', '#category-confirm');
    $('body').on('click', '#category-confirm', async (e) => {
        e.preventDefault();

        let category_id_value = '';
        let select_parent = document.getElementById('category_parent');
        let item_select_parent = select_parent.options[select_parent.selectedIndex];
        if (item_select_parent.value != 'none') {
            category_id_value = item_select_parent.value;
            let select_child = document.getElementById('category_child1');
            let item_select_child = select_child.options[select_child.selectedIndex];
            if (item_select_child.value != 'none') {
                category_id_value = item_select_child.value;
                let childs_category = document.getElementById('childs_category');
                // console.log(childs_category.childNodes.length);
                if (childs_category.childNodes.length != 0) {
                    for (let index = 0; index < childs_category.childNodes.length; index++) {
                        // console.log(childs_category.childNodes[index].lastChild);
                        let select_childs = childs_category.childNodes[index].lastChild;
                        let item_select_childs = select_childs.options[select_childs.selectedIndex];
                        if (item_select_childs.value != 'none') {
                            category_id_value = item_select_childs.value;
                        } else {
                            break;
                        }
                    }
                }
            }
        } else {
            show_error_element('#category_parent', 'Seleccione la categoria del producto', 'border-warning');
            show_error_element([{
                target: "#category_parent",
                msg: "Seleccione la categoria del producto",
                btstyle: "border-warning",
                action: "hidden"
            }]);
        }

        aretha('#collapseOne').removeClass('show');
        // console.log(category_id_value);
        let attributes = await apiML('#body-api').requestEndPoint({
            EndPoint: {
                endpoint_parent: 'categories',
                endpointChild: 'attributes',
                body: {
                    category_id: category_id_value,
                }
            },
        });
        // console.log(attributes)
        let attributes_add = document.getElementById('attributes_add');
        let view_attr = document.getElementById('view_attr');
        view_attr.innerHTML = '';
        for (let index = 0; index < attributes.data.length; index++) {
            const attr = attributes.data[index];
            let attr_comp = null;
            let attr_label = null;
            let select_attr = null;
            let div_col = document.createElement('div');
            div_col.setAttribute('class', 'col-md-2 mb-2 ms-1');
            // console.log(attr.id);
            if (attr.id != 'ITEM_CONDITION') {
                if (attr.value_type == 'boolean') {
                    attr_label = document.createElement('label');
                    attr_label.setAttribute('class', 'form-label');
                    attr_label.setAttribute('form', `${attr.id}`);
                    attr_label.appendChild(document.createTextNode(`${attr.name}`));
                    attr_comp = document.createElement('select');
                    attr_comp.setAttribute('class', 'form-select  apiML-param');
                    attr_comp.setAttribute('type', 'select');
                    attr_comp.setAttribute('id', 'input-attr');
                    attr_comp.setAttribute('id-attr', `${attr.id}`);
                    attr_comp.setAttribute('id-endpoint', 'attributes');
                    attr_comp.setAttribute('type-endpoint', 'list');
                    attr_comp.setAttribute('type-struct', 'object');
                    attr_comp.setAttribute('value-type', 'string');
                    attr_comp.setAttribute('tag-var', 'attr');
                    attr_comp.setAttribute('select-sndata', 'all');
                    for (let index_val = 0; index_val < attr.values.length; index_val++) {
                        let op_sel = document.createElement('option');
                        op_sel.setAttribute('value', `${attr.values[index_val].id}`);
                        op_sel.appendChild(document.createTextNode(`${attr.values[index_val].name}`));
                        attr_comp.appendChild(op_sel);
                    }
                    div_col.appendChild(attr_label);
                    div_col.appendChild(attr_comp);
                } else if (attr.value_type == 'list') {
                    attr_label = document.createElement('label');
                    attr_label.setAttribute('class', 'form-label');
                    attr_label.setAttribute('form', `${attr.id}`);
                    attr_label.appendChild(document.createTextNode(`${attr.name}`));
                    attr_comp = document.createElement('select');
                    attr_comp.setAttribute('class', 'form-select  apiML-param');
                    attr_comp.setAttribute('id', 'input-attr');
                    attr_comp.setAttribute('id-attr', `${attr.id}`);
                    attr_comp.setAttribute('id-endpoint', 'attributes');
                    attr_comp.setAttribute('type-endpoint', 'list');
                    attr_comp.setAttribute('type-struct', 'object');
                    attr_comp.setAttribute('value-type', 'string');
                    attr_comp.setAttribute('tag-var', 'attr');
                    attr_comp.setAttribute('select-sndata', 'all');
                    for (let index_val = 0; index_val < attr.values.length; index_val++) {
                        let op_sel = document.createElement('option');
                        op_sel.setAttribute('value', `${attr.values[index_val].id}`);
                        op_sel.appendChild(document.createTextNode(`${attr.values[index_val].name}`));
                        attr_comp.appendChild(op_sel);
                    }
                    div_col.appendChild(attr_label);
                    div_col.appendChild(attr_comp);
                } else {
                    let group_div = document.createElement('div');
                    attr_label = document.createElement('label');
                    attr_label.setAttribute('class', 'form-label');
                    attr_label.setAttribute('form', `${attr.id}`);
                    attr_label.appendChild(document.createTextNode(`${attr.name}`));
                    attr_comp = document.createElement('input');
                    attr_comp.setAttribute('class', 'form-control  apiML-param');
                    attr_comp.setAttribute('type', 'text');
                    attr_comp.setAttribute('id', 'input-attr');
                    attr_comp.setAttribute('id-attr', `${attr.id}`);
                    attr_comp.setAttribute('id-endpoint', 'attributes');
                    attr_comp.setAttribute('type-endpoint', 'list');
                    attr_comp.setAttribute('type-struct', 'object');
                    attr_comp.setAttribute('value-type', 'string');
                    attr_comp.setAttribute('tag-var', 'attr');

                    div_col.appendChild(attr_label);
                    if ('values' in attr) {
                        attr_comp.setAttribute('value-id', '');
                        select_attr = document.createElement('select');
                        select_attr.setAttribute('class', 'form-select  z-2');
                        select_attr.setAttribute('id', `select_attr_${attr.id}`);

                        let op_sel = null;
                        op_sel = document.createElement('option');
                        op_sel.setAttribute('value', 'none');
                        op_sel.setAttribute('input-id', 'none');
                        op_sel.appendChild(document.createTextNode(`...`));
                        select_attr.appendChild(op_sel);
                        for (let index_val = 0; index_val < attr.values.length; index_val++) {
                            op_sel = document.createElement('option');
                            op_sel.setAttribute('value', `${attr.values[index_val].id}`);
                            op_sel.setAttribute('input-id', `${attr.id}`);
                            op_sel.appendChild(document.createTextNode(`${attr.values[index_val].name}`));
                            select_attr.appendChild(op_sel);
                        }

                        select_attr.appendChild(op_sel);
                        select_attr.hidden = true;
                    }
                    if ('allowed_units' in attr) {
                        attr_comp.setAttribute('need-unit', 'y');

                        group_div.setAttribute('class', 'input-group mb-3');
                        let sl_units = document.createElement('select');
                        sl_units.setAttribute('class', 'form-select');
                        sl_units.setAttribute('id', `${attr.id}_unit`);
                        for (let index_val = 0; index_val < attr.allowed_units.length; index_val++) {
                            let op_units = document.createElement('option');
                            op_units.setAttribute('value', `${attr.allowed_units[index_val].id}`);
                            op_units.appendChild(document.createTextNode(`${attr.allowed_units[index_val].name}`));
                            sl_units.appendChild(op_units);
                        }
                        group_div.appendChild(attr_comp);
                        if (select_attr != null) {
                            group_div.append(select_attr);
                        }
                        group_div.appendChild(sl_units);
                        div_col.appendChild(group_div);
                    } else {
                        div_col.appendChild(attr_comp);
                        if (select_attr != null) {
                            div_col.append(select_attr);
                        }

                    }
                }
                if (!attr.tags.hasOwnProperty('required')) {
                    if (!attr.tags.hasOwnProperty('catalog_required')) {
                        if (!attr.tags.hasOwnProperty('catalog_listing_required')) {
                            if (!attr.tags.hasOwnProperty('conditional_required')) {
                                div_col.hidden = true;
                                attr_comp.classList.remove('apiML-param');
                                let op_attr_add = document.createElement('option');
                                op_attr_add.setAttribute('value', `attr_id_${attr.id}`)
                                op_attr_add.appendChild(document.createTextNode(attr.name));
                                attributes_add.appendChild(op_attr_add);
                            }

                        }
                    }
                }
                if (attr.tags.hasOwnProperty('allow_variations')) {
                    let col_att_var = document.createElement('div');
                    col_att_var.setAttribute('class', 'col-md-6');
                    col_att_var.innerHTML = `<input class="form-check-input" type="checkbox" value="attr_id_${attr.id}" input-id="${attr.id}" id="check_attr_var">` +
                        '<label class="form-check-label">' +
                        `  ${attr.name}` +
                        '</label>';
                    // ch_att_var.setAttribute('value', `item_var_attr_${attr.id}`);
                    // ch_att_var.setAttribute('input-id', `${attr.id}`);
                    // ch_att_var.appendChild(document.createTextNode(`${attr.name}`));
                    // document.getElementById('attr_var').appendChild(op_att_var);
                    document.getElementById('attr_var').appendChild(col_att_var);
                }
                if (attr.tags.hasOwnProperty('variation_attribute')) {
                    let op_att_var = document.createElement('option');
                    op_att_var.setAttribute('value', `attr_id_${attr.id}`);
                    op_att_var.appendChild(document.createTextNode(`${attr.name}`));
                    select_variation_attr.appendChild(op_att_var);
                }
                if (attr.tags.hasOwnProperty('grid_template_required')) {
                    document.getElementById('panel_grid').hidden = false;
                }

                div_col.setAttribute('id', `attr_id_${attr.id}`);
                view_attr.appendChild(div_col);
            }
        }
        aretha('#collapseTwo').addClass('show');
    });
    $('body').off('click', '#check_attr_var');
    $('body').on('click', '#check_attr_var', (e) => {
        if (e.target.checked) {
            list_attr_vars.push(e.target.value);
        } else {
            delete list_attr_vars[list_attr_vars.indexOf(e.target.value)];
        }
    });
    $('body').off('click', '#add_img_btn');
    $('body').on('click', '#add_img_btn', (e) => {
        let select_child = document.getElementById('img_add');
        // console.log(select_child.options);
        let index_select = select_child.options.selectedIndex
        let row_images = document.getElementById('images_upload');
        // console.log(select_child.options[index_select].value);Va
        if (count_images_add <= max_nuber_images) {
            switch (select_child.options[index_select].value) {
                case 'url':
                    // console.log(document.getElementById('img_input').childElementCount);
                    let div_col = document.createElement('div');
                    div_col.setAttribute('class', 'col-md-4 mb-2');
                    let label_img_input = document.createElement('label');
                    label_img_input.setAttribute('class', 'form-label');
                    label_img_input.setAttribute('form', `img${document.getElementById('img_input').childElementCount+1}`);
                    label_img_input.appendChild(document.createTextNode(`URL imagen ${document.getElementById('img_input').childElementCount+1}`));
                    let input_img = document.createElement('input');
                    input_img.setAttribute('class', 'form-control apiML-param');
                    input_img.setAttribute('type', 'text');
                    input_img.setAttribute('id', `img${document.getElementById('img_input').childElementCount+1}`);
                    input_img.setAttribute('id-endpoint', 'pictures');
                    input_img.setAttribute('type-endpoint', 'list');
                    input_img.setAttribute('type-struct', 'object');
                    input_img.setAttribute('value-type', 'string');
                    input_img.setAttribute('tag-var', 'source');
                    div_col.appendChild(label_img_input);
                    div_col.appendChild(input_img);
                    document.getElementById('img_input').appendChild(div_col);
                    count_images_add++;
                    break;
                case 'id':
                    break;
            }
        } else {
            alert(`Solo se permite agregar hasta ${max_nuber_images} imagenes`);
        }

    });
    $('body').off('click', '#upload_img_btn');
    $('body').on('click', '#upload_img_btn', async (e) => {
        let files = document.getElementById('formFileMultiple').files;
        let index_files = 0;
        const formData_img = new FormData()
        // console.log(files);
        // console.log(count_images_add);
        if ((files.length != 0)) {
            if ((count_images_add + files.length) > max_nuber_images) {
                index_files = max_nuber_images - count_images_add;
                alert(`se agregaran solo ${index_files} imagenes de las seleccionadas. rebasa el limite permitido`)
            } else if (files.length > max_nuber_images) {
                alert(`numero de images permitido rebasado`);
            }
        };
        formData_img.append('filesLength', files.length);
        formData_img.append('data', JSON.stringify({
            EndPoint: {
                endpoint_parent: 'pictures',
                endpointChild: 'upload',
            },
        }));
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            formData_img.append(`file${i}`, file);
        }
        let imgs_details = await apiML().uploadImage(formData_img);
        // console.log(imgs_details);
        let row_images = document.getElementById('images_upload');
        for (let index = 0; index < imgs_details.data.length; index++) {
            console.log(imgs_details.data[index]);
            let div_col = document.createElement('div');
            div_col.setAttribute('class', 'col-md-4 mb-2');
            let label_img_input = document.createElement('label');
            label_img_input.setAttribute('class', 'form-label');
            label_img_input.setAttribute('form', `img${document.getElementById('img_input').childElementCount+1}`);
            label_img_input.appendChild(document.createTextNode(`Imagen subida ${document.getElementById('img_input').childElementCount+1}`));
            let input_img = document.createElement('input');
            input_img.setAttribute('class', 'form-control apiML-param');
            input_img.setAttribute('type', 'input');
            input_img.setAttribute('value', `${imgs_details.data[index]}`);
            input_img.setAttribute('id', `img${document.getElementById('img_input').childElementCount+1}`);
            input_img.setAttribute('id-endpoint', 'pictures');
            input_img.setAttribute('type-endpoint', 'list');
            input_img.setAttribute('type-struct', 'object');
            input_img.setAttribute('value-type', 'string');
            input_img.setAttribute('tag-var', 'id');
            input_img.readOnly = true;
            div_col.appendChild(label_img_input);
            div_col.appendChild(input_img);
            document.getElementById('img_input').appendChild(div_col);
            count_images_add++;
        }

    });
    $('body').off('focusin', '#input-attr');
    $('body').on('focusin', '#input-attr', (e) => {
        e.preventDefault();
        // console.log(e);
        if (tmp_prev_elem != null) {
            tmp_prev_elem.hidden = true;
        }
        tmp_prev_elem = document.getElementById(`select_attr_${e.target.getAttribute('id-attr')}`);

        if (tmp_prev_elem != null) {
            tmp_prev_elem.hidden = false;
            // select_child.previousElementSibling.value=select_child.options[select_child.selectedIndex].innerHTML;
            // // select_child.previousElementSibling.setAttribute('')
            // select_child.hidden=true;      
            tmp_prev_elem.addEventListener('change', (e) => {
                e.preventDefault();

                let select_child = aretha().targetize(e);
                select_child.previousElementSibling.value = select_child.options[select_child.selectedIndex].innerHTML;
                select_child.previousElementSibling.setAttribute('value-id', `${select_child.options[select_child.selectedIndex].value}`);
                // select_child.previousElementSibling.setAttribute('')
                select_child.hidden = true;

            });
            tmp_prev_elem.addEventListener('focusout', (e) => {
                e.preventDefault();

                let select_child = aretha().targetize(e);
                // select_child.previousElementSibling.value = select_child.options[select_child.selectedIndex].innerHTML;
                // select_child.previousElementSibling.setAttribute('')
                select_child.hidden = true;

            });
            tmp_prev_elem.addEventListener('blur', (e) => {
                e.preventDefault();

                let select_child = aretha().targetize(e);
                // select_child.previousElementSibling.value = select_child.options[select_child.selectedIndex].innerHTML;
                // select_child.previousElementSibling.setAttribute('')
                select_child.hidden = true;

            });
        }
    });
    $('body').off('input', '#input-attr');
    $('body').on('input', '#input-attr', (e) => {
        e.preventDefault();
        // console.log(e);
        e.target.removeAttribute('value-id');

    });
    $('body').off('click', '#add_attr_var_btn');
    $('body').on('click', '#add_attr_var_btn', (e) => {

        // console.log(list_attr_vars);
        let nodes_check_attr_var = document.querySelectorAll('input[id="check_attr_var"]');
        nodes_check_attr_var.forEach((element) => {
            element.disabled = true;
        });

        count_variations_add += 1;

        let card_var_col = document.createElement('div');
        card_var_col.setAttribute('class', 'card col-md-6')
        card_var_col.setAttribute('id', `card-var-${count_variations_add}`)

        card_var_col.innerHTML =
            '<div class="card-header text-center col-md-12">' +
            '<div class="row">' +
            `<div class="col-md-11">Variacion ${count_variations_add} </div>  <div class="col align-self-end"><button type="button" class="btn-close" id="btn-close-var"  id-card="card-var-${count_variations_add}" aria-label="Close"></button> </div>` +
            '</div>' +
            '</div>' +
            `<div class="card-body col-md-12" id="body-var-${count_variations_add}">` +
            `<div class="row" id="body-var${count_variations_add}-p1" >` +
            '<div class="col-md-5">' +
            '<label for="condition" class="form-label">Cantidad disponible</label>' +
            `<input type="text" class="form-control apiML-param-var${count_variations_add}" id="available_quantity" value-type="number" aria-label="catidad disponible"> ` +
            '</div>' +
            '<div class="col-md-5" >' +
            `<label for="price_var${count_variations_add}" class="form-label">Precio</label>` +
            '<div class="input-group ">' +
            '<span class="input-group-text">$</span>' +
            `<input type="text" class="form-control apiML-param-var${count_variations_add}" value="${document.getElementById('price').value}" id-endpoint="price" value-type="number" aria-label="Amount (to the nearest dollar)" readonly>` +
            '</div>' +
            '</div>' +
            '</div>' +
            `<div class="row pt-3">` +
            '<div class="col-md-12">' +
            '<p class="h3 text-center">Atributos</p>' +
            '</div>' +
            '<div class="col-md-12  align-self-start">' +
            '<div class="input-group">' +
            // `<select class="form-select" id="attributes_add_var" id-var="${count_variations_add}" aria-label="Default select example">` +
            // '<option value="none" selected>atributos</option>' +
            // '</select>' +
            `<button class="btn btn-outline-secondary" type="button" id-var="${count_variations_add}" id="add_attr_btn_var">Agregar</button>` +
            `<button class="btn btn-outline-secondary" type="button" id-var="${count_variations_add}"  id="remove_attr_btn_var">Eliminar</button>` +
            '</div>' +
            '</div>' +
            '</div>' +
            `<div class="row " id="view_attr_var${count_variations_add}">` +
            '</div>' +
            '<div class="row justify-content-md-center pt-3">' +
            '<div class="col-md-12">' +
            '<p class="h3 text-center">Imagenes</p>' +
            '</div>' +
            '<div class="col-md-6 ">' +
            '<label for="formFileMultiple" class="form-label">Seleccione fuente imagen</label>' +
            '<div class="input-group mb-3">' +
            `<select class="form-select" id="img_add_var${count_variations_add}"  id-var="${count_variations_add}"  aria-label="Default select example">` +
            '<option value="url">url</option>' +
            '<option value="none" disabled>id mercado libre</option>' +
            '</select>' +
            `<button class="btn btn-outline-secondary" type="button" id="add_img_btn_vars"  id-var="${count_variations_add}" >Agregar</button>` +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            `<label for="file_multi_var${count_variations_add}" class="form-label">Seleccione archivos</label>` +
            '<div class="input-group mb-3">' +
            `<input class="form-control" type="file" id="file_multi_var${count_variations_add}" multiple>` +
            `<button class="btn btn-outline-secondary" type="button" id="upload_img_btn_vars"  id-var="${count_variations_add}" ">subir</button>` +
            '</div>' +
            '</div>' +
            '</div>' +
            `<div class="row" id="img_input_var${count_variations_add}">` +
            '</div>' +
            '</div>';


        let card_body = card_var_col.childNodes[1].childNodes[0];
        list_attr_vars.forEach((id_attr) => {
            let ori_attr = document.getElementById(`${id_attr}`);

            let attr_var = ori_attr.cloneNode(true);
            attr_var.hidden = false;
            attr_var.setAttribute('class', 'col-md-5');
            for (let i = 0; i < attr_var.childNodes.length; i++) {
                let child = attr_var.childNodes[i];

                if (child.getAttribute('id') == 'select_attr_COLOR') {
                    child.setAttribute('id', `${child.getAttribute('id')}_var${count_variations_add}`)
                } else {
                    if (child.classList.contains('apiML-param')) {
                        child.classList.replace('apiML-param', `apiML-param-var${count_variations_add}`);
                        child.setAttribute('id', `${child.getAttribute('id')}-var`)
                        child.setAttribute('id-var', `${count_variations_add}`);
                    } else {
                        switch (child.tagName.toLowerCase()) {
                            case 'input':
                                if (child.type != 'file') {
                                    child.classList.add(`apiML-param-var${count_variations_add}`);
                                    child.setAttribute('id', `${child.getAttribute('id')}-var`)
                                    child.setAttribute('id-var', `${count_variations_add}`);
                                }
                                break;
                            case 'select':
                                child.classList.add(`apiML-param-var${count_variations_add}`);
                                child.setAttribute('id', `${child.getAttribute('id')}-var`)
                                child.setAttribute('id-var', `${count_variations_add}`);
                                break;
                            case 'textarea':
                                child.classList.add(`apiML-param-var${count_variations_add}`);
                                child.setAttribute('id', `${child.getAttribute('id')}-var`)
                                child.setAttribute('id-var', `${count_variations_add}`);
                                break;
                        }
                    }
                    if (child.hasAttribute('id-endpoint')) {
                        child.setAttribute('id-endpoint', 'attribute_combinations');
                    }
                }
            }
            card_body.appendChild(attr_var);

            if (!ori_attr.hidden) {
                ori_attr.hidden = true;
                let item = ori_attr.querySelector('[id="input-attr"]');
                item.classList.remove('apiML-param');
            }
        });



        let select_vars_attrs = select_variation_attr.cloneNode(true);
        select_vars_attrs.setAttribute('id', `select_attr_var${count_variations_add}`);
        // let attr_var = document.getElementById(`${select_variation_attr.options[select_variation_attr.selectedIndex].value}`).cloneNode(true);
        // attr_var.hidden = false;
        // attr_var.setAttribute('class', 'col-md-5');
        // card_body.appendChild(attr_var);

        // for (let i = 0; i < attr_var.childNodes.length; i++) {
        //     let child = attr_var.childNodes[i];
        //     if (child.classList.contains('apiML-param')) {
        //         child.classList.replace('apiML-param', `apiML-param-var${count_variations_add}`);
        //         // child.classList.append(`apiML-param-var${count_variations_add}`);
        //     } else {
        //         switch (child.tagName.toLowerCase()) {
        //             case 'input':
        //                 if (child.type != 'file') {
        //                     child.classList.add(`apiML-param-var${count_variations_add}`);
        //                 }
        //                 break;
        //             case 'select':
        //                 child.classList.add(`apiML-param-var${count_variations_add}`);
        //                 break;
        //             case 'textarea':
        //                 child.classList.add(`apiML-param-var${count_variations_add}`);
        //                 break;
        //         }
        //     }
        //     if (child.hasAttribute('id-endpoint')) {
        //         child.setAttribute('id-endpoint', 'attribute_combinations');
        //     }
        //     // console.log(child);
        // }
        // // console.log(card_var_col.childNodes[1].childNodes[1].childNodes[1].firstChild);
        card_var_col.childNodes[1].childNodes[1].childNodes[1].firstChild.insertAdjacentElement('afterbegin', select_vars_attrs);
        document.getElementById('attr_var_view').appendChild(card_var_col);

    });
    $('body').off('click', '#btn-close-var');
    $('body').on('click', '#btn-close-var', (e) => {
        e.preventDefault();
        let id_var = aretha().targetize(e).getAttribute('id-card');
        if (count_variations_add > 0) {
            document.getElementById(id_var).remove();
            count_variations_add--;
            if (imgs_vars.hasOwnProperty(`var_${id_var}`)) {
                delete imgs_vars[`var_${id_var}`]
            }
        }

        if (count_variations_add == 0) {
            let nodes_check_attr_var = document.querySelectorAll('input[id="check_attr_var"]');
            nodes_check_attr_var.forEach((element) => {
                element.disabled = false;
            });
            imgs_vars = {};
        }

    });
    $('body').off('click', '#add_attr_btn_var');
    $('body').on('click', '#add_attr_btn_var', (e) => {
        e.preventDefault();
        let id_var = aretha().targetize(e).getAttribute('id-var');
        let select_child = document.getElementById(`select_attr_var${id_var}`);
        let item_select = select_child.options[select_child.selectedIndex];

        if (document.getElementById(`${item_select.value}_var${id_var}`) != null) {
            let tmp_exits_var = document.getElementById(`${item_select.value}_var${id_var}`);
            tmp_exits_var.hidden = false;
            for (let i = 0; i < tmp_exits_var.childNodes.length; i++) {
                let child = tmp_exits_var.childNodes[i];
                if (child.classList.contains(`apiML-param-var${id_var}`)) {
                    child.classList.remove(`apiML-param-var${id_var}`);
                    // child.classList.append(`apiML-param-var${count_variations_add}`);
                }
            }
        } else {
            let tmp_attr_var = document.getElementById(item_select.value).cloneNode(true);
            tmp_attr_var.setAttribute('id', `${tmp_attr_var.getAttribute('id')}_var${id_var}`);
            tmp_attr_var.setAttribute('class', 'col-md-3 mb-2 mt-2');
            for (let i = 0; i < tmp_attr_var.childNodes.length; i++) {
                let child = tmp_attr_var.childNodes[i];
                if (child.classList.contains('apiML-param')) {
                    child.classList.replace('apiML-param', `apiML-param-var${id_var}`);
                    // child.classList.append(`apiML-param-var${count_variations_add}`);
                } else {
                    switch (child.tagName.toLowerCase()) {
                        case 'input':
                            if (child.type != 'file') {
                                child.classList.add(`apiML-param-var${id_var}`);
                            }
                            break;
                        case 'select':
                            child.classList.add(`apiML-param-var${id_var}`);
                            break;
                        case 'textarea':
                            child.classList.add(`apiML-param-var${id_var}`);
                            break;
                    }
                }
                // if (child.hasAttribute('id-endpoint')) {
                //     child.setAttribute('id-endpoint', 'attribute_combinations');
                // }
                // console.log(child);
            }
            tmp_attr_var.hidden = false;
            document.getElementById(`view_attr_var${id_var}`).appendChild(tmp_attr_var);
        }


        // console.log(tmp_attr_var);

    });
    $('body').off('focusin', '#input-attr-var');
    $('body').on('focusin', '#input-attr-var', (e) => {
        e.preventDefault();
        // console.log(e);
        if (tmp_prev_elem != null) {
            tmp_prev_elem.hidden = true;
        }
        let id_var = e.target.getAttribute('id-var');
        tmp_prev_elem = document.getElementById(`select_attr_${e.target.getAttribute('id-attr')}_var${id_var}`);

        if (tmp_prev_elem != null) {
            tmp_prev_elem.hidden = false;
            // select_child.previousElementSibling.value=select_child.options[select_child.selectedIndex].innerHTML;
            // // select_child.previousElementSibling.setAttribute('')
            // select_child.hidden=true;      
            tmp_prev_elem.addEventListener('change', (e) => {
                e.preventDefault();

                let select_child = aretha().targetize(e);
                select_child.previousElementSibling.value = select_child.options[select_child.selectedIndex].innerHTML;
                select_child.previousElementSibling.setAttribute('value-id', `${select_child.options[select_child.selectedIndex].value}`);
                // select_child.previousElementSibling.setAttribute('')
                select_child.hidden = true;

            });
            tmp_prev_elem.addEventListener('focusout', (e) => {
                e.preventDefault();

                let select_child = aretha().targetize(e);
                // select_child.previousElementSibling.value = select_child.options[select_child.selectedIndex].innerHTML;
                // select_child.previousElementSibling.setAttribute('')
                select_child.hidden = true;

            });
            tmp_prev_elem.addEventListener('blur', (e) => {
                e.preventDefault();

                let select_child = aretha().targetize(e);
                // select_child.previousElementSibling.value = select_child.options[select_child.selectedIndex].innerHTML;
                // select_child.previousElementSibling.setAttribute('')
                select_child.hidden = true;

            });
        }
    });
    $('body').off('input', '#input-attr-var');
    $('body').on('input', '#input-attr-var', (e) => {
        e.preventDefault();
        // console.log(e);
        e.target.removeAttribute('value-id');

    });
    $('body').off('click', '#remove_attr_btn_var');
    $('body').on('click', '#remove_attr_btn_var', (e) => {
        e.preventDefault();
        let id_var = aretha().targetize(e).getAttribute('id-var');
        let select_child = document.getElementById(`select_attr_var${id_var}`);
        let item_select = select_child.options[select_child.selectedIndex];
        let tmp_attr_var = document.getElementById(`${item_select.value}_var${id_var}`);
        if (tmp_attr_var != null) {
            tmp_attr_var.hidden = true;
            for (let i = 0; i < tmp_attr_var.childNodes.length; i++) {
                let child = tmp_attr_var.childNodes[i];
                if (child.classList.contains(`apiML-param-var${id_var}`)) {
                    child.classList.remove(`apiML-param-var${id_var}`);
                    // child.classList.append(`apiML-param-var${count_variations_add}`);
                }
            }
        }

    });
    $('body').off('click', '#add_img_btn_vars');
    $('body').on('click', '#add_img_btn_vars', (e) => {
        e.preventDefault();
        let id_var = aretha().targetize(e).getAttribute('id-var');
        let select_child = document.getElementById(`img_add_var${id_var}`);
        let index_select = select_child.options.selectedIndex
        let count_imgs_var = 0;
        if (imgs_vars.hasOwnProperty(`var_${id_var}`)) {
            count_imgs_var = imgs_vars[`var_${id_var}`].count_imgs_add;
        } else {
            imgs_vars[`var_${id_var}`] = {};
            imgs_vars[`var_${id_var}`]['count_imgs_add'] = 0;
        }
        if (count_images_add <= max_nuber_images) {
            switch (select_child.options[index_select].value) {
                case 'url':
                    // console.log(document.getElementById('img_input').childElementCount);
                    let index_child_img = document.getElementById(`img_input_var${id_var}`).childElementCount + 1;
                    let div_col = document.createElement('div');
                    div_col.setAttribute('class', 'col-md-4 mb-2');
                    let label_img_input = document.createElement('label');
                    label_img_input.setAttribute('class', 'form-label');
                    label_img_input.setAttribute('form', `img${index_child_img}_var${id_var}`);
                    label_img_input.appendChild(document.createTextNode(`URL imagen ${index_child_img}`));
                    let input_img = document.createElement('input');
                    input_img.setAttribute('class', `form-control apiML-param-var${id_var}`);
                    input_img.setAttribute('type', 'text');
                    input_img.setAttribute('id', `img${index_child_img}_var${id_var}`);
                    input_img.setAttribute('id-endpoint', 'picture_ids');
                    input_img.setAttribute('type-endpoint', 'list');
                    // input_img.setAttribute('type-struct', 'object');
                    input_img.setAttribute('value-type', 'string');
                    // input_img.setAttribute('tag-var', 'source');
                    div_col.appendChild(label_img_input);
                    div_col.appendChild(input_img);
                    document.getElementById(`img_input_var${id_var}`).appendChild(div_col);
                    count_imgs_var++;
                    break;
                case 'id':
                    break;
            }
            imgs_vars[`var_${id_var}`]['count_imgs_add'] = count_imgs_var;
        } else {
            alert(`Solo se permite agregar hasta ${max_nuber_images} imagenes`);
        }

    });
    $('body').off('click', '#upload_img_btn_vars');
    $('body').on('click', '#upload_img_btn_vars', async (e) => {
        e.preventDefault();
        let id_var = aretha().targetize(e).getAttribute('id-var');
        let count_imgs_var = 0;
        if (imgs_vars.hasOwnProperty(`var_${id_var}`)) {
            count_imgs_var = imgs_vars[`var_${id_var}`].count_imgs_add;
        } else {
            imgs_vars[`var_${id_var}`] = {};
            imgs_vars[`var_${id_var}`]['count_imgs_add'] = 0;
        }
        let files = document.getElementById(`file_multi_var${id_var}`).files;
        let index_files = 0;
        const formData_img = new FormData()
        // console.log(files);
        // console.log(count_images_add);
        if ((files.length != 0)) {
            if ((count_imgs_var + files.length) > max_nuber_images_var) {
                index_files = max_nuber_images_var - count_imgs_var;
                alert(`se agregaran solo ${index_files} imagenes de las seleccionadas. rebasa el limite permitido`)
            } else if (files.length > max_nuber_images_var) {
                alert(`numero de images permitido rebasado`);
            }
        };
        formData_img.append('filesLength', files.length);
        formData_img.append('data', JSON.stringify({
            EndPoint: {
                endpoint_parent: 'pictures',
                endpointChild: 'upload',
            },
        }));
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            formData_img.append(`file${i}`, file);
        }
        let imgs_details = await apiML().uploadImage(formData_img);
        console.log(imgs_details);
        // let row_images = document.getElementById(`img_input_var${id_var}`);
        for (let index = 0; index < imgs_details.data.length; index++) {
            let index_child_img = document.getElementById(`img_input_var${id_var}`).childElementCount + 1;
            console.log(imgs_details.data[index]);
            let div_col = document.createElement('div');
            div_col.setAttribute('class', 'col-md-4 mb-2');
            let label_img_input = document.createElement('label');
            label_img_input.setAttribute('class', 'form-label');
            label_img_input.setAttribute('form', `img${index_child_img}_var${id_var}`);
            label_img_input.appendChild(document.createTextNode(`Imagen subida ${index_child_img}`));
            let input_img = document.createElement('input');
            input_img.setAttribute('class', `form-control apiML-param-var${id_var}`);
            input_img.setAttribute('type', 'input');
            input_img.setAttribute('value', `${imgs_details.data[index]}`);
            input_img.setAttribute('id', `img${index_child_img}_var${id_var}`);
            input_img.setAttribute('id-endpoint', 'picture_ids');
            input_img.setAttribute('type-endpoint', 'list');
            // input_img.setAttribute('type-struct', 'object');
            input_img.setAttribute('value-type', 'string');
            // input_img.setAttribute('tag-var', 'id');
            input_img.readOnly = true;
            div_col.appendChild(label_img_input);
            div_col.appendChild(input_img);
            document.getElementById(`img_input_var${id_var}`).appendChild(div_col);
            count_imgs_var++;
        }
        imgs_vars[`var_${id_var}`]['count_imgs_add'] = count_imgs_var;
    });
    // $('body').off('change', '#select_var_attr_item');
    // $('body').on('change', '#select_var_attr_item', async (e) => {
    //     e.preventDefault();
    //     let select_child = aretha().targetize(e);
    //     let item_select = select_child.options[select_child.selectedIndex];
    //     let tmp_attr_var=document.getElementById(item_select.value).cloneNode(true);
    //     tmp_attr_var.setAttribute('id',`${tmp_attr_var.getAttribute('id')}_var${select_child.getAttribute('id-var')}`)
    //     console.log(tmp_attr_var);


    // });

    $('body').off('click', '#get_attr_grid_layout');
    $('body').on('click', '#get_attr_grid_layout', async (e) => {
        e.preventDefault();

        // console.log(domain_id_value);
        let chart_attrs = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'catalog',
                endpointChild: 'searchChars',
                body: {
                    domain_id: domain_id_value,
                }
            },
        });
        console.log(chart_attrs);

    });

    $('body').off('click', '#get_shipp_mode');
    $('body').on('click', '#get_shipp_mode', async (e) => {
        e.preventDefault();
        // let body_json=apiML('.apiML-shipp').jsontargetize();
        // console.log(body_json);
        const msg_types_me = {
            'drop_off': 'Mercado Envios',
            'xd_drop_off': 'Mercado Envios Places',
            'cross_doking': 'Mercado Envios Coleta',
            'self_service': 'Mercado Envios Flex',
            'fulfillment': 'Mercado Envios Full',
            'not_specified': 'Acordar con vendedor',
        };

        let pref_ship = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'users',
                endpointChild: 'shipping_preferences',
            },
        });
        // console.log(pref_ship);
        let select_shipp = document.getElementById('mode_shipp');
        select_shipp.innerHTML = '';
        pref_ship.data.logistics.forEach((item_log) => {
            item_log.types.forEach((type_mode) => {
                let option_log = document.createElement('option');
                option_log.setAttribute('value', `${item_log.mode}|${type_mode.type}`);
                if (type_mode.type in msg_types_me) {
                    option_log.appendChild(document.createTextNode(`${msg_types_me[type_mode.type]}`));
                } else {
                    option_log.appendChild(document.createTextNode(`${type_mode.type}`));
                }
                select_shipp.appendChild(option_log);
            });
        });

    });
    $('body').off('click', '#val_publishe');
    $('body').on('click', '#val_publish', async (e) => {
        e.preventDefault();

        let body_json = apiML('.apiML-param').jsontargetize();
        body_json['buying_mode'] = "buy_it_now";
        if (count_variations_add > 0) {
            body_json['variations'] = [];
            for (let index = 1; index <= count_variations_add; index++) {
                let vars = apiML(`.apiML-param-var${index}`).jsontargetize();
                // console.log(vars);
                body_json['variations'].push(vars);
            }
        }
        console.log(body_json);

        let val_publish = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'items',
                endpointChild: 'validate',
                body: body_json,
            },
        });
        console.log(val_publish);
        if (!val_publish.hasOwnProperty('reject')) {
            aretha('#collapseThree').addClass('border-success');
            // document.getElementById('item_id').setAttribute('value', `${val_publish.data.id}`);
            setInterval(() => {
                aretha('#collapseThree').removeClass('show');
                aretha('#collapseThree').removeClass('border-success');
                aretha('#collapseFour').addClass('show');
            }, 1000);
        } else {
            aretha(e).addClass('border-danger');
        }

    });
    $('body').off('click', '#publish_send');
    $('body').on('click', '#publish_send', async (e) => {
        e.preventDefault();
        let body_json = apiML('.apiML-param').jsontargetize();
        body_json['buying_mode'] = "buy_it_now";
        body_json['buying_mode'] = "buy_it_now";
        if (count_variations_add > 0) {
            body_json['variations'] = [];
            for (let index = 1; index <= count_variations_add; index++) {
                let vars = apiML(`.apiML-param-var${index}`).jsontargetize();
                // console.log(vars);
                body_json['variations'].push(vars);
            }
        }
        console.log(body_json);
        let val_publish = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'items',
                endpointChild: 'publish',
                body: body_json,
            },
        });

        console.log(val_publish);
        if (!val_publish.hasOwnProperty('reject')) {
            aretha('#collapseThree').addClass('border-success');
            document.getElementById('item_id').setAttribute('value', `${val_publish.data.id}`);
            setInterval(() => {
                aretha('#collapseThree').removeClass('show');
                aretha('#collapseThree').removeClass('border-success');
                aretha('#collapseFour').addClass('show');
            }, 1000);
        } else {
            aretha(e).addClass('border-danger');
        }



        // console.log(val_publish);

    });
    $('body').off('click', '#description_add');
    $('body').on('click', '#description_add', async (e) => {
        e.preventDefault();
        let item_id = document.getElementById('item_id').getAttribute('value');
        console.log(item_id);
        if ((item_id != '') && (item_id != null)) {
            let body_json = apiML('.apiML-dp').jsontargetize();
            body_json['item_id'] = item_id;
            console.log(body_json);
            let add_dp = await apiML().requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'items',
                    endpointChild: 'descritionAdd',
                    body: body_json,
                },
            });
            console.log(add_dp);
        }


    });
</script>