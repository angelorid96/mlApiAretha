<div class="row mb-n5" id="">
    <div class="col-xs-12 col-sm-12 col-xl-8">
        <!-- <div class="row">
            <div class="card col-xl-12">
                <div class="card-body">
                    <div class="card-title">
                        <h5 class="small-title">Categoria del prodcuto para ML</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-2 ms-1">
                            <label for="category_parent" class="form-label">Categoria</label>
                            <select class="form-select " id="category_parent" aria-label="Default select">

                            </select>
                        </div>
                        <div class="col-md-5 mb-2 ms-1">
                            <label for="category_child1" class="form-label">Categoria especifica</label>
                            <select class="form-select " id="category_child" aria-label="Default select" disabled>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="modal fade" id="chartsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">categorizador</h5>
                        </div>
                        <div class="modal-body row" id="">
                            <div class="card col-xl-12">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="small-title">Categoria del prodcuto para ML</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <label for="category_parent" class="form-label">Titulo publicacion ML</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control apiML-param" value-type="string" aria-describedby="titlePubilish" id="title">
                                                <button class="btn btn-primary" id="predictCategoryBTN">
                                                    Predecir Categorias
                                                </button>
                                            </div>
                                            <div id="titlePubilish" class="form-text">
                                                Recomendaciones para el titulo Producto + Marca + modelo del producto + etc.
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="row" id="content_predict">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-xl-12">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="small-title">Categoria del prodcuto para ML</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 mb-2 ms-1">
                                            <label for="category_parent" class="form-label">Categoria</label>
                                            <select class="form-select " id="category_parent" aria-label="Default select">

                                            </select>
                                        </div>
                                        <div class="col-md-5 mb-2 ms-1">
                                            <label for="category_child1" class="form-label">Categoria especifica</label>
                                            <select class="form-select " id="category_child" aria-label="Default select" disabled>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <!-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="createTableCharts">Crear tabla</button> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let modal_title = document.getElementById('chartsModal');
        let modal_categorization = bootstrap.Modal.getOrCreateInstance(modal_title);
        let count_predict = 0;


        modal_categorization.show();

        apiML('category_parent').categories();
        $('body').off('change', '#category_parent');
        $('body').on('change', '#category_parent', async (e) => {
            // e.preventDefault();
            document.getElementById('category_child').disabled = false;
            document.getElementById('category_child').innerHTML = '';
            let select_parent = aretha().targetize(e);
            let item_select = select_parent.options[select_parent.selectedIndex];
            // console.log(item_select.value);
            if (item_select.value != 'none') {
                apiML().removeSiblingElements(select_parent.parentElement.nextElementSibling, true);
                let category = await apiML('category_child').category(item_select.value);

            } else {
                document.getElementById('category_child').innerHTML = '';
                document.getElementById('category_child').disabled = true;
            }

        });
        $('body').off('change', '#category_child');
        $('body').on('change', '#category_child', async (e) => {
            // e.preventDefault();

            let select_parent = aretha().targetize(e);
            let item_select = select_parent.options[select_parent.selectedIndex];
            // console.log(item_select.value);
            if (item_select.value != 'none') {
                apiML().removeSiblingElements(select_parent);
                let category_data = await apiML().category(item_select.value);
                console.log(category_data);
                if (category_data.data.children_categories.length != 0) {
                    let root_elemt = select_parent.parentElement.parentElement;
                    let col = document.createElement('div');
                    let label_col = document.createElement('label');
                    let select_col = document.createElement('select');

                    col.setAttribute('class', 'col-md-5 mb-2 ms-1');
                    label_col.appendChild(document.createTextNode('Categoria especifica'));
                    col.appendChild(label_col);

                    select_col.setAttribute('class', 'form-select');
                    select_col.setAttribute('id', 'category_child');

                    let optin_cate = document.createElement('option');
                    optin_cate.setAttribute('value', 'none');
                    optin_cate.appendChild(document.createTextNode('seleccione categoria'));
                    select_col.appendChild(optin_cate);

                    for (let index in category_data.data.children_categories) {
                        // console.log(cat_pre.data[index]);
                        let item = category_data.data.children_categories[index];
                        optin_cate = document.createElement('option');
                        optin_cate.setAttribute('value', `${item['id']}`);
                        optin_cate.appendChild(document.createTextNode(`${item['name']}`));
                        select_col.appendChild(optin_cate);
                    }
                    col.appendChild(select_col);
                    root_elemt.appendChild(col);
                } else {

                }
                console.log(category_data);
            } else {
                document.getElementById('category_child').innerHTML = '';
                document.getElementById('category_child').disabled = true;
            }

        });
        $('body').off('click', '#predictCategoryBTN');
        $('body').on('click', '#predictCategoryBTN', async (e) => {
            console.log('debug categorization');

            if (count_predict > 3) {
                alert('Le sugerios escoger manualmente la categoria...');
            } else {
                let cat_pred = await apiML('content_predict').categorization(aretha('#title').val());
                if (cat_pred.hasOwnProperty('reject') && cat_pred.reject.error == 'predict_null') {
                    count_predict += 1;
                }
            }
        });
    </script>