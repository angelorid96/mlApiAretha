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
                            <input type="text" class="form-control" aria-describedby="titlePubilish" id="title">
                            <div id="titlePubilish" class="form-text">
                                Recomendaciones para el titulo Producto + Marca + modelo del producto + etc.
                            </div>
                        </div>
                        <div class="col-md-3 mt-0">
                            <a class="btn btn-primary disabled" id="predictCategoryBTN" role="button" aria-disabled="true">
                                Predecir Categorias
                            </a>
                        </div>
                        <div class="col-md-12 mb-0">
                            <div class="col-md-12 text-center h4" id="error_category" style="visibility:hidden;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="collapse" id="predictCategory">
                                <div class="card card-body">
                                    <div class="row justify-content-md-center pb-2" id="view_category" style="visibility:hidden;">
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
                                <div class="col-md-3 mb-2 ms-1">
                                    <label for="price" class="form-label">Precio</label>
                                    <div class="input-group ">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control" id="price" aria-label="Amount (to the nearest dollar)">
                                        <select class="form-select" id="moneda" aria-label="Default select example">
                                            <option value="MXN">MXN</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="condition" class="form-label">Estado del producto</label>
                                    <select class="form-select" id="condition" aria-label="Default select example">
                                        <option value="none">...</option>
                                        <option value="2230284" value-text="new">Nuevo</option>
                                        <option value="2230581" value-text="used">Usado</option>
                                        <option value="2230582" value-text="Reacondicionado">Reacondicionado</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="condition" class="form-label">Cantidad disponible</label>
                                    <input type="text" class="form-control" id="available_quantity" aria-label="catidad disponible">
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="condition" class="form-label">Tipo de publicacion</label>
                                    <select class="form-select" id="condition" aria-label="Default select example">
                                        <option value="none">...</option>
                                        <option value="gold_pro">Premium</option>
                                        <option value="old_special">Clásica</option>
                                        <option value="free">Gratuita</option>
                                    </select>
                                </div>
                                <div class="col-md-3  ms-2 mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDisabled" id="buying_mode" checked disabled>
                                        <label class="form-check-label" for="flexRadioCheckedDisabled">
                                            Modalidad de compra inmediata
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="condition" class="form-label">Tipo de garantia</label>
                                    <select class="form-select" id="WARRANTY_TYPE" aria-label="Default select example">
                                        <option value="none">...</option>
                                        <option value="2230279">Garantia de fabrica</option>
                                        <option value="2230280">Garantia del vendedor</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2 ms-1">
                                    <label for="price" class="form-label">Tiempo de garantia</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control" id="WARRANTY_TIME" aria-label="Amount (to the nearest dollar)">
                                        <select class="form-select" id="WARRANTY_TIME_UNIT" aria-label="Default select example">
                                            <option value="none">...</option>
                                            <option value="dias">dias</option>
                                            <option value="meses">meses</option>
                                            <option value="años">años</option>
                                        </select>
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
                            </div>
                        </div>
                    </div>
                    <div class="row g-3" id="view_attr">

                    </div>
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
    let show_error_element = (target, msg, action, time_view = 5000) => {
        aretha(target).addClass(action);
        document.getElementById('error_category').style.visibility = 'visible';
        document.getElementById('error_category').appendChild(document.createTextNode(msg));
        setTimeout(() => {
            document.getElementById('error_category').style.visibility = 'hidden';
            aretha(target).removeClass(action);
            document.getElementById('error_category').innerHTML = '';
        }, time_view);
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
            document.getElementById('view_category').style.visibility = 'visible';
            document.getElementById('predictCategory').setAttribute('class', 'collapse show')

        } else {
            document.getElementById('view_category').style.visibility = 'hidden';
            input_title.setAttribute('class', input_title.getAttribute('class') + ' border-warning');
            document.getElementById('error_category').style.visibility = 'visible';
            document.getElementById('error_category').appendChild(document.createTextNode('El campo <strong>Titulo</strong> no se permite vacio.'));
            setTimeout(() => {
                document.getElementById('error_category').style.visibility = 'hidden';
                input_title.setAttribute('class', input_title.getAttribute('class').replace('border-warning', ''));
                document.getElementById('error_category').innerHTML = '';
            }, 5000);
        }
    });
    $('body').off('click', '#checkPredictCategory');
    $('body').on('click', '#checkPredictCategory', (e) => {
        // e.preventDefault();
        let btn_predict = document.getElementById('predictCategoryBTN');
        if (e.target.checked) {
            btn_predict.setAttribute('class', btn_predict.getAttribute('class').replace('disabled', ''));
            btn_predict.setAttribute('aria-disabled', 'false');
            document.getElementById('category_parent').disabled = true;
            document.getElementById('category_child1').disabled = true;
            document.getElementById('childs_category').innerHTML = '';
        } else {
            btn_predict.setAttribute('class', `${btn_predict.getAttribute('class')} disabled`)
            btn_predict.setAttribute('aria-disabled', 'true');
            document.getElementById('view_category').innerHTML = '';
            document.getElementById('view_category').style.visibility = 'hidden';
            document.getElementById('category_parent').disabled = false;
            document.getElementById('childs_category').innerHTML = '';
            document.getElementById('category_child1').innerHTML = '';
            document.getElementById('category_parent').options.selectedIndex = 0;
        }
        document.getElementById('predictCategory').setAttribute('class', document.getElementById('predictCategory').getAttribute('class').replace('show', ''))
    });
    $('body').off('click', '#predict_cat');
    $('body').on('click', '#predict_cat', async (e) => {
        e.preventDefault();
        // console.log(e);
        let category = await apiML('#body-api').requestEndPoint({
            EndPoint: {
                endpoint_parent: 'products',
                endpointChild: 'category',
                body: {
                    category_id: aretha().targetize(e).getAttribute('category_id'),
                }
            },
        });
        console.log(category);
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
                    select_parent.options.selectedIndex = index_select_new;
                } else if (index == 1) {
                    document.getElementById('category_child1').innerHTML = '';
                    let option_cat_item = document.createElement('option');
                    option_cat_item.selected = true;
                    option_cat_item.setAttribute('value', category.data.path_from_root[0].id);
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
                    option_cat_item.setAttribute('value', category.data.path_from_root[0].id);
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
            select_parent.options.selectedIndex = index_select_new;
        }


    });
    $('body').off('change', '#category_parent');
    $('body').on('change', '#category_parent', async (e) => {
        // e.preventDefault();
        // console.log(e);
        document.getElementById('category_child1').disabled = false;
        let select_parent = aretha().targetize(e);
        let index_select = select_parent.options.selectedIndex
        let item_select = select_parent.options[index_select];
        // console.log(item_select.value);
        if (item_select.value != 'none') {
            let category = await apiML('#body-api').requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'products',
                    endpointChild: 'category',
                    body: {
                        category_id: item_select.value,
                    }
                },
            });
            // console.log(category);
            let max_length_title = category.data.settings.max_title_length;
            let title = document.getElementById('title');
            title.setAttribute('maxlength', `${max_length_title}`);
            // console.log(title.value);
            if (title.value.length > max_length_title) {
                document.getElementById('error_category').style.visibility = 'visible';
                document.getElementById('error_category').appendChild(document.createTextNode(`Esta categoria solo acepta ${max_length_title} caracteres.`));
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
        // console.log(select_child);
        let index_select = select_child.options.selectedIndex
        let item_select = select_child.options[index_select];
        // console.log(item_select.value);
        if (item_select.value != 'none') {
            let category = await apiML('#body-api').requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'products',
                    endpointChild: 'category',
                    body: {
                        category_id: item_select.value,
                    }
                },
            });
            // console.log(category.data);
            let max_length_title = category.data.settings.max_title_length;
            let title = document.getElementById('title');
            title.setAttribute('maxlength', `${max_length_title}`);
            // console.log(title.value);
            if (title.value.length > max_length_title) {
                document.getElementById('error_category').style.visibility = 'visible';
                document.getElementById('error_category').appendChild(document.createTextNode(`Esta categoria solo acepta ${max_length_title} caracteres.`));
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
        let index_select = select_child.options.selectedIndex
        let item_select = select_child.options[index_select];
        // console.log(item_select.value);
        if (item_select.value != 'none') {
            let category = await apiML('#body-api').requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'products',
                    endpointChild: 'category',
                    body: {
                        category_id: item_select.value,
                    }
                },
            });
            // console.log(category.data);
            let max_length_title = category.data.settings.max_title_length;
            let title = document.getElementById('title');
            title.setAttribute('maxlength', `${max_length_title}`);
            // console.log(title.value);
            if (title.value.length > max_length_title) {
                document.getElementById('error_category').style.visibility = 'visible';
                document.getElementById('error_category').appendChild(document.createTextNode(`Esta categoria solo acepta ${max_length_title} caracteres.`));
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
        let select_child = document.getElementById('attributes_add');
        // console.log(select_child);
        let index_select = select_child.options.selectedIndex
        console.log(index_select);
        select_child.options[index_select].visibility = 'visible';

    });
    $('body').off('click', '#category-confirm');
    $('body').on('click', '#category-confirm', async (e) => {
        e.preventDefault();

        let category_id_value = '';
        let select_parent = document.getElementById('category_parent');
        let item_select_parent = select_parent.options[select_parent.options.selectedIndex];
        if (item_select_parent.value != 'none') {
            category_id_value = item_select_parent.value;
            let select_child = document.getElementById('category_parent');
            let item_select_child = select_child.options[select_child.options.selectedIndex];
            if (item_select_child.value != 'none') {
                category_id_value = item_select_child.value;
                let childs_category = document.getElementById('childs_category');
                // console.log(childs_category.childNodes.length);
                if (childs_category.childNodes.length != 0) {
                    for (let index = 0; index < childs_category.childNodes.length; index++) {
                        // console.log(childs_category.childNodes[index].lastChild);
                        let select_childs = childs_category.childNodes[index].lastChild;
                        let item_select_childs = select_childs.options[select_childs.options.selectedIndex];
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
        }

        aretha('#collapseOne').removeClass('show');
        console.log(category_id_value);
        let attributes = await apiML('#body-api').requestEndPoint({
            EndPoint: {
                endpoint_parent: 'products',
                endpointChild: 'required_attributes',
                body: {
                    category_id: category_id_value,
                }
            },
        });
        console.log(attributes)
        let attributes_add = document.getElementById('attributes_add');
        let view_attr = document.getElementById('view_attr');
        for (let index = 0; index < attributes.data.length; index++) {
            const attr = attributes.data[index];
            let attr_comp = null;
            let attr_label = null;
            let div_col = document.createElement('div');
            div_col.setAttribute('class', 'col-md-2 mb-2 ms-1')
            if (attr.component == 'COMBO') {
                attr_label = document.createElement('label');
                attr_label.setAttribute('class', 'form-label');
                attr_label.setAttribute('form', `${attr.attributes[0].id}`);
                attr_label.appendChild(document.createTextNode(`${attr.label}`));
                attr_comp = document.createElement('input');
                attr_comp.setAttribute('class', 'form-select');
                attr_comp.setAttribute('type', 'select');
                attr_comp.setAttribute('id', `${attr.attributes[0].id}`);
                for (let index_val = 0; index_val < attr.attributes[0].values.length; index_val++) {
                    let op_sel = document.createElement('option');
                    op_sel.setAttribute('value', `${attr.attributes[0].values[index_val].id}`);
                    op_sel.appendChild(document.createTextNode(`${attr.attributes[0].values[index_val].name}`));
                    attr_comp.appendChild(op_sel);
                }
                div_col.appendChild(attr_label);
                div_col.appendChild(attr_comp);
            } else if (attr.component == 'BOOLEAN_INPUT') {
                attr_label = document.createElement('label');
                attr_label.setAttribute('class', 'form-label');
                attr_label.setAttribute('form', `${attr.attributes[0].id}`);
                attr_label.appendChild(document.createTextNode(`${attr.label} ${attr.attributes[0].name}`));
                attr_comp = document.createElement('input');
                attr_comp.setAttribute('class', 'form-select');
                attr_comp.setAttribute('type', 'select');
                attr_comp.setAttribute('id', `${attr.attributes[0].id}`);
                for (let index_val = 0; index_val < attr.attributes[0].values.length; index_val++) {
                    let op_sel = document.createElement('option');
                    op_sel.setAttribute('value', `${attr.attributes[0].values[index_val].id}`);
                    op_sel.appendChild(document.createTextNode(`${attr.attributes[0].values[index_val].name}`));
                    attr_comp.appendChild(op_sel);
                }
                div_col.appendChild(attr_label);
                div_col.appendChild(attr_comp);
            } else {
                attr_label = document.createElement('label');
                attr_label.setAttribute('class', 'form-label');
                attr_label.setAttribute('form', `${attr.attributes[0].id}`);
                attr_label.appendChild(document.createTextNode(`${attr.label}`));
                attr_comp = document.createElement('input');
                attr_comp.setAttribute('class', 'form-control');
                // attr_comp.setAttribute('type', `${attr.attributes[0].value_type}`);
                attr_comp.setAttribute('type', 'text');
                attr_comp.setAttribute('maxlength', `${attr.attributes[0].value_max_length}`);
                attr_comp.setAttribute('id', `${attr.attributes[0].id}`);
                div_col.appendChild(attr_label);
                div_col.appendChild(attr_comp);
            }
            if (!attr.attributes[0].tags.includes('required')) {
                if (!attr.attributes[0].tags.includes('catalog_required')) {
                    if (!attr.attributes[0].tags.includes('catalog_listing_required')) {
                        div_col.style.visibility = 'hidden';
                        let op_attr_add = document.createElement('option');
                        op_attr_add.setAttribute('value', `${attr.attributes[0].id}`)
                        op_attr_add.appendChild(document.createTextNode(attr.attributes[0].name));
                        attributes_add.appendChild(op_attr_add);
                    }
                }
            }
            view_attr.appendChild(div_col);
        }
        aretha('#collapseTwo').addClass('show');
    });
</script>