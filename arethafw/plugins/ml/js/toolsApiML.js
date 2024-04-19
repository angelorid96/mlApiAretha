const apiML = (target) => ({

    //isAuth proporciona un menu Nav utilizando bootstrap con los endpoints que quiera mostrar
    // confDomJson debera contener las siguentes llaves
    // url: si tiene un archivo template html donde esta contenido su menu
    // scope: lista de endpoints con los que se generara su menu
    // orientation: orientacion del menu si existe scope
    // En caso de no pasar ninguna de las llaves solo se generara el identificador del usurio con una serie de opciones realcionadas a este
    // defaultMenu valor booleano si decea un menu por default. si no establece orientation sera horizontal
    // Si no se incluye un identficaro de elemento ID o CLASS. no se mostrara nada.
    /*
        si aun no se ha autenticado la funcion regresar un boton para mandarlo a el autenticador de ML
        aparte de un codigo de error (string) cque puede tomar los siguentes estados
            valid_user_authentication
            required_authentication
    */
    isAuth: async (confDomJson, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        const response = await fetch('arethafw/plugins/ml/php/isAuthToken.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: JSON.stringify(confDomJson),
        });
        if (response.status == 404) {
            const failPage = await fetch(pageNotFound.url, {
                method: 'GET'
            });
            document.getElementById(pageNotFound.target).innerHTML = await failPage.text();

        } else {
            const data = await response.json();
            // console.log(data);
            if (typeof document.getElementById(target) === 'object') {
                if ('html' in data.isAuth) {
                    if (data.isAuth.status != 'fail') {
                        aretha(target).html(aretha(target).html() + data['isAuth']['html']);
                    } else {
                        aretha(target).html(data['isAuth']['html']);
                    }
                } else {
                    return data.isAuth;
                }
            } else {
                return data.isAuth;
            }
        }
    },
    /*
        funcion que rediriegue a la autenticacion y autroizacion del usuario en la app
        este paso solo debe relizarce 1 vez o cuando el refresh_token expiro.
        isExpireToken.php se encarga de validar si tanto el token como refresh_token ya no son validos

    */
    redirecAuth: async (pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        const response = await fetch('arethafw/plugins/ml/php/isAuthToken.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "endpoint": "auth"
            }),
        });
        if (response.status == 404) {
            const failPage = await fetch(pageNotFound.url, {
                method: 'GET'
            });
            document.getElementById(pageNotFound.target).innerHTML = await failPage.text();

        } else {
            const data = await response.json();
            if (data.urlAuth.status == 'success') {
                // console.log(response.url);
                window.open(data.urlAuth.url, '_self');
            }
        }

        // aretha().get({
        //     "url": "arethafw/plugins/ml/php/isAuthToken.php",
        //     "data": "endpoint=auth",
        //     "useNotFoundPage": true,
        //     "notFoundPage": 'arethafw/html/404.html',
        //     success: function (data) {
        //         const response = JSON.parse(data);
        //         // console.log(response);
        //         if (response.urlAuth.status == 'success') {
        //             // console.log(response.url);
        //             window.open(response.urlAuth.url, '_self');
        //         }
        //     },
        //     notfound: function (xhr) {
        //         aretha(target).html(xhr);
        //     }
        // });
    },
    post: async (json_data, url, target_op, innet_id = false, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(json_data),
        });

        if (response.status == 404) {
            const failPage = await fetch(pageNotFound.url, {
                method: 'GET'
            });
            document.getElementById(pageNotFound.target).innerHTML = await failPage.text();
            return await failPage.text();
        } else {
            const data = await response.text();
            if (innet_id) {
                if (typeof target !== 'undefined') {
                    aretha(target).html(data);
                } else if (typeof target_op !== 'undefined') {
                    aretha(target_op).html(data);
                }
            } else {
                return JSON.parse(data);
            }

        }


    }, get: async (params_url, url, target_op, innet_id = false, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        const queryString = new URLSearchParams(params_url).toString();
        let fullUrl = url;
        if (queryString.length != 0) {
            fullUrl = `${url}?${queryString}`;
        }
        const response = await fetch(fullUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });

        if (response.status == 404) {
            const failPage = await fetch(pageNotFound.url, {
                method: 'GET'
            });
            document.getElementById(pageNotFound.target).innerHTML = await failPage.text();
            return await failPage.text();
        } else {
            const data = await response.text();
            if (innet_id) {
                if (typeof target !== 'undefined') {
                    aretha(target).html(data);
                } else if (typeof target_op !== 'undefined') {
                    aretha(target_op).html(data);
                }
            } else {
                // console.log(data);
                if (data.length !== 0) {
                    return JSON.parse(data);
                } else {
                    return Array();
                }
            }
        }

    },
    requestEndPoint: async (json_data, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        let data = await apiML().post(json_data, 'arethafw/plugins/ml/php/requestEndPoint.php', pageNotFound);
        // console.log(data);

        if (data.status == 'warning') {
            let msg = '';
            aretha('#error-title').html('Error al obtener informacion!');

            if (data.endpoint_data.reject.hasOwnProperty('error')) {
                msg = `${msg} \n <p class="card-text"> Error: ${data.endpoint_data.reject.error}</p>`;
            }
            if (data.endpoint_data.reject.hasOwnProperty('cause')) {
                msg = `${msg} \n <p class="card-text"> Causa: ${data.endpoint_data.reject.cause}</p>`;
            }
            aretha('#error-body').html(`${msg}`);
            document.getElementById('card-error').hidden = false;
            // document.getElementById('card-error').focus();


            setTimeout(() => {
                document.getElementById('card-error').hidden = true;
            }, 9000);
        } else {
            if (typeof document.getElementById(target) === 'object') {
                if (json_data.urlPage) {
                    if (data.status == 'success') {
                        aretha(target).html(data.html);
                        document.getElementById(target.replace('#', '')).hidden = false;
                    }
                }
            }
        }

        return data.endpoint_data;
    },
    uploadImage: async (dataform_sn) => {
        const response = await fetch('arethafw/plugins/ml/php/requestEndPoint.php', {
            method: 'POST',
            body: dataform_sn,
        });
        const data = await response.json();

        if (data.status == 'warning') {
            aretha('#error-title').html('Error al obtener informacion!');
            aretha('#error-body').html(`<p class="card-text">${data.endpoint_data.reject.error}</p>`);
            document.getElementById('card-error').hidden = false;
            // document.getElementById('card-error').focus();

            setTimeout(() => {
                document.getElementById('card-error').hidden = true;
            }, 9000);
        } else {
            if (typeof document.getElementById(target) === 'object') {
                if (dataform_sn.urlPage) {
                    if (data.status == 'success') {
                        aretha(target).html(data.html);
                        document.getElementById(target.replace('#', '')).hidden = false;
                    }
                }
            }
        }

        return data.endpoint_data;
    },
    /* 
    onbtencion de los datos de los campos de formulario y conversion a formato json para enviar como body al EndpOint de ML
    atributos de un elemento y funcion
    id-endpoint -> estabece la clave a la cual se asociara un valor  yasea un objecto, vector o dato simple si no existe el atributo el se asiganra el valor de id
    id-attr-> valor id que espesificara el campo al que se asignara esto es empleado por ML si noesite la propiedad tomara el valor de id
    type-endpoint -> tipo de estructura que contendra la llave id-endPoint podra ser un la lista, objecto o dato simple
    value-type -> tipo de dato a convertir para el valor del campo del formulario number para numeros, boolean para valor logico y string para tipo texto 
    tag-var-> clave para asociar el valor del campo del formulacio cuando la estructtura del valor es un objecto, se emplea con el valor "attr"
    cuando el id-endPoint contendra los atributos de un producto o una estructura similar.
    el valor "chart"  cambiara la estructura de valor para el formato de las propiedades de la guia de tallas espesifico para las filas
    el valor "chartV2"  cambia la estructura del valor para el atributo de la guia de tallas

    type-struct-> si la estructura del valor del campo del formulari sera un objecto o un dato simple
    need-unit -> agrega caracter de medida al valor del campo de formulario. ej cm, ", ft, etc.
    multi-val -> establece si un elemento select contendra multiples valores a ingresar estos deberan estar separados por el caracter | 
    para los atributos value y tag-var no valido para estructuras tipo attr.
    select-sndata ->  indica que valores se utilizaran para agregar de n  el elemento select, "all" para obtener valor del atributo value y html del option
     "value" para obtener solo para obtener el value del atributo option y "text" para obtener solo el valor html del elemento option
    value-id -> para indicar el valor del value_id que es utilizado en los attributos u otras propiedades. esto para elementos input text 
    del cual el valor ya tenga asociado un id esto lo propociona la api ML
    row-index -> indice posicion para guia de tallas con este se agregaran las propieades correspondienes a cada fila nueva
    */
    jsontargetize: () => {
        let json_endpoints_data = {

        };
        let id_endpoint = '';
        let type_endpoint = '';
        let key_value = '';
        let type_value = '';
        let struct_value = '';
        let id_attr = '';
        let value_unit = '';
        let mulit_val = '';
        let select_sndata = '';

        let items;
        let format_value = (value, value_id = '') => {
            let value_format;

            if (type_value == 'number') {
                value_format = parseInt(value);
            } else if (type_value == 'boolean') {
                console.log(value);
                if (typeof value !== 'boolean') {
                    value_format = (value.toLowerCase() === 'true');
                } else {
                    value_format = value;
                }
            } else {
                value_format = value + value_unit;
            }

            if (struct_value == 'object' && key_value == 'attr') {
                if (type_value == 'string' || type_value == '') {
                    value_format = `"${value_format}"`;
                }
                // console.log(value_format);
                if (value == '') {
                    return JSON.parse(`{"id":"${id_attr}","value_id":"${value_id}"}`);
                } else if (value_id == '') {
                    return JSON.parse(`{"id":"${id_attr}","value_name":${value_format}}`);
                }

                return JSON.parse(`{"id":"${id_attr}","value_id":"${value_id}","value_name":${value_format}}`);
            } else if ((struct_value == 'object' && key_value == 'chart') || (struct_value == 'object' && key_value == 'chartV2')) {
                if (type_value == 'string' || type_value == '') {
                    value_format = `"${value_format}"`;
                }
                // console.log(value_format);
                if (value == '') {
                    return JSON.parse(`{"id":"${id_attr}","values":[{"id":"${value_id}"}]}`);
                } else if (value_id == '') {
                    return JSON.parse(`{"id":"${id_attr}","values":[{"name":${value_format}}]}`);
                }

                return JSON.parse(`{"id":"${id_attr}","values":[{"id":"${value_id}","name":${value_format}}]}`);
            } else if (struct_value == 'object') {
                if (type_value == 'string' || type_value == '') {
                    value_format = `"${value_format}"`;
                }
                return JSON.parse(`{"${key_value}":${value_format}}`);
            }

            return value_format;
        }
        let insert_value = (value_name, value_id = '') => {

            let value_format = format_value(value_name, value_id);

            if (type_endpoint == 'list') {
                if (!json_endpoints_data.hasOwnProperty(id_endpoint)) {
                    json_endpoints_data[id_endpoint] = [];
                }
                if (key_value == 'chart') {
                    if (index_row != -1) {

                        if (json_endpoints_data[id_endpoint].at(index_row) !== undefined) {
                            json_endpoints_data[id_endpoint][index_row]["attributes"].push(value_format);
                        } else {
                            json_endpoints_data[id_endpoint].push({ "attributes": [value_format] });
                        }
                    } else {
                        if (json_endpoints_data[id_endpoint].at(index_row) !== undefined) {
                            json_endpoints_data[id_endpoint]["attributes"].push(value_format);
                        } else {
                            json_endpoints_data[id_endpoint]["attributes"] = [value_format];
                        }
                    }
                } else {
                    json_endpoints_data[id_endpoint].push(value_format);
                }
            } else if (type_endpoint == 'object') {
                if (!json_endpoints_data.hasOwnProperty(id_endpoint)) {
                    json_endpoints_data[id_endpoint] = {};
                }
                if (key_value == 'chart') {
                    if (!json_endpoints_data[id_endpoint].hasOwnProperty("attributes")) {
                        json_endpoints_data[id_endpoint]["attributes"] = [value_format];
                    } else {
                        json_endpoints_data[id_endpoint]["attributes"].push(value_format);
                    }
                } else {
                    json_endpoints_data[id_endpoint][key_value] = value_format;
                }
            } else {
                json_endpoints_data[id_endpoint] = value_format;
            }
        }
        let mulit_values_insert = (value_id) => {
            let key_multi_vals = key_value.split('|');
            let values_id = value_id.split('|');
            for (let index = 0; index < values_id.length; index++) {
                key_value = key_multi_vals[index];
                insert_value(values_id[index]);
            }
        }
        let define_attr_vars = (item_elm) => {
            id_endpoint = '';
            type_endpoint = '';
            key_value = '';
            type_value = '';
            struct_value = '';
            value_unit = '';
            select_sndata = 'value';
            index_row = -1;
            mulit_val = false;

            if (item_elm.hasAttribute('id-endpoint')) {
                id_endpoint = item_elm.getAttribute('id-endpoint');
            } else if (item_elm.hasAttribute('id')) {
                id_endpoint = item_elm.getAttribute('id');
            }
            if (item_elm.hasAttribute('id-attr')) {
                id_attr = item_elm.getAttribute('id-attr');
            } else if (item_elm.hasAttribute('id')) {
                id_attr = item_elm.getAttribute('id');
            }
            if (item_elm.hasAttribute('type-endpoint')) {
                type_endpoint = item_elm.getAttribute('type-endpoint');
            }
            if (item_elm.hasAttribute('value-type')) {
                type_value = item_elm.getAttribute('value-type');
            }
            if (item_elm.hasAttribute('tag-var')) {
                key_value = item_elm.getAttribute('tag-var');
            }
            if (item_elm.hasAttribute('type-struct')) {
                struct_value = item_elm.getAttribute('type-struct');
            }
            if (item_elm.hasAttribute('need-unit')) {
                let item_unit = item_elm.nextElementSibling;
                let value_unit_tmp = item_unit.options[item_unit.selectedIndex].value;
                if (value_unit_tmp.match(RegExp('[\"\']'))) {
                    value_unit = value_unit = `\\${value_unit_tmp}`;
                } else {
                    value_unit = ` ${value_unit_tmp}`;
                }
            }
            if (item_elm.hasAttribute('multi-val')) {
                mulit_val = (item_elm.getAttribute('multi-val') == 'true');
            }
            if (item_elm.hasAttribute('select-sndata')) {
                select_sndata = item_elm.getAttribute('select-sndata');
            }
            if (item_elm.hasAttribute('row-index')) {
                index_row = parseInt(item_elm.getAttribute('row-index'));
            }
        }

        el = document.querySelectorAll(target);

        if (el.length == 1 && aretha(target).is('form')) {
            items = el[0].elements;
        } else {
            items = el;
        }
        // console.log(document.querySelectorAll(target));

        if (el.length >= 1) {
            for (let item of items) {
                // console.log(item);

                define_attr_vars(item);
                switch (item.tagName.toLowerCase()) {
                    case 'input':
                        if (item.type === 'file') {

                        } else if (item.type === 'radio') {
                            if (item.checked) {
                                if (item.hasAttribute('value')) {
                                    insert_value(item.value);
                                } else {
                                    insert_value(item.checked);
                                }
                            }

                        } else if (item.type === 'checkbox') {
                            if (item.checked) {
                                if (item.hasAttribute('value')) {
                                    insert_value(item.value);
                                } else {
                                    insert_value(item.checked);
                                }
                            }
                        } else {
                            if (item.hasAttribute('value-id')) {
                                insert_value(item.value, item.getAttribute('value-id'));
                            } else {
                                insert_value(item.value);
                            }
                        }
                        break;
                    case 'select':
                        let val_id = item.options[item.selectedIndex].value;
                        let val_name = item.options[item.selectedIndex].text;
                        if (item.options[item.selectedIndex].hasAttribute('input-id')) {
                            id_attr = item.options[item.selectedIndex].getAttribute('input-id');
                        }

                        // console.log(`multi-val:${mulit_val}`);
                        if (mulit_val) {
                            mulit_values_insert(val_id);
                        } else {
                            if (select_sndata == 'value') {
                                // console.log(val_id.match(RegExp('^[0-9]+$')));
                                if (val_id.match(RegExp('^[0-9]+$'))) {
                                    insert_value('', val_id);
                                } else {
                                    insert_value(val_id);
                                }
                            } else if (select_sndata == 'text') {
                                insert_value(val_name);
                            } else if (select_sndata == 'all') {
                                insert_value(val_name, val_id);
                            }
                        }
                        break;
                    case 'textarea':
                        insert_value(item.value);
                        break;
                }

            }

        }
        // console.log(json_endpoints_data);
        return json_endpoints_data;
    },
    verifyNotify: async () => {
        let data = await apiML().get({}, 'resources/verifyLogNotify.php');
        // console.log(data);
        if (typeof target !== 'undefined') {
            if (data.notis.length != 0) {
                let container_toast = document.getElementById(target);
                let toast = null;
                container_toast.innerHTML = '';
                data.notis.forEach((item) => {
                    // console.log(item);
                    toast = document.createElement('div');
                    toast.setAttribute('class', 'toast');
                    toast.setAttribute('role', 'alert');
                    toast.setAttribute('aria-live', 'assertive');
                    toast.setAttribute('aria-atomic', 'true');
                    let toast_innerHtml = '<div class="toast-header">' +
                        `<strong class="me-auto">Notifiacion ML ${item.topic}</strong>` +
                        '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
                        '</div>' +
                        '<div class="toast-body">' +
                        `<a class="btn btn-primary" role="button" resource="${item.resource}" topic="${item.topic}" id="btnAcNTMl">Ver contendo</a>` +
                        '</div>';
                    toast.innerHTML = toast_innerHtml;
                    container_toast.appendChild(toast);
                    const new_toats = bootstrap.Toast.getOrCreateInstance(toast);
                    new_toats.show();
                });
            }
        }
    },
    categorization: async (title, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        

        if ((typeof title === 'string') && (title.length != 0)) {
            let categories_predict = await apiML().requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'site',
                    endpointChild: 'predict',
                    body: {
                        q: encodeURIComponent(title),
                    }
                }
            }, pageNotFound);
            console.log(categories_predict);
            if(categories_predict.data.length!=0){
                if ((typeof target !== 'undefined')){
                    document.getElementById(`${target}`).innerHTML='';
                    for (let index in categories_predict.data) {
                        // console.log(cat_pre.data[index]);
                        let item = categories_predict.data[index];
                        let div_col = document.createElement('div');
                        div_col.setAttribute('class', 'col-md-4');
                        let btn_category_item = document.createElement('a');
                        btn_category_item.setAttribute('class', 'btn btn-md border-black fs-6');
                        btn_category_item.setAttribute('role', 'button');
                        // btn_category_item.setAttribute('id', `predict_cat${index}`);
                        btn_category_item.setAttribute('id', 'predict_cat');
                        btn_category_item.setAttribute('category_id', item['category_id']);
                        btn_category_item.setAttribute('domain_id', item['domain_id']);
                        btn_category_item.appendChild(document.createTextNode(`Dominio:${item['domain_name']} > Categoria:${item['category_name']}`));
                        div_col.appendChild(btn_category_item);
                        document.getElementById(`${target}`).appendChild(div_col);
                    }
                }
                return categories_predict;
            }else{
                return {
                    'reject': {
                        'error': 'predict_null',
                        'code': 400,
                        'cause': 'la prediccion no tiene resultados'
                    }
                }
            }
        }

        return {
            'reject': {
                'error': 'fail_title',
                'code': 400,
                'cause': 'title no es un string o esta vacio'
            }
        }
    }, categories: async (pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {

        let categories = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'site',
                endpointChild: 'categories',
            },
        }, pageNotFound);
        // console.log(categories);
        if ((typeof target !== 'undefined') && (document.getElementById(`${target}`).tagName.toLowerCase() == 'select')) {
            let optin_cate = document.createElement('option');
            optin_cate.setAttribute('value', 'none');
            optin_cate.appendChild(document.createTextNode('seleccione categoria'));
            document.getElementById(`${target}`).appendChild(optin_cate);
            for (let index in categories.data) {
                // console.log(cat_pre.data[index]);
                let item = categories.data[index];
                optin_cate = document.createElement('option');
                optin_cate.setAttribute('value', `${item['id']}`);
                optin_cate.appendChild(document.createTextNode(`${item['name']}`));
                document.getElementById(`${target}`).appendChild(optin_cate);
            }
        }
        return categories;
        // return {
        //     'reject': {
        //         'error': 'fail_title',
        //         'code': 400,
        //         'cause': 'title no es un string o esta vacio'
        //     }
        // }
    }, category: async (category_value, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        if ((typeof category_value === 'string') && (category_value.length != 0)) {
            let category = await apiML().requestEndPoint({
                EndPoint: {
                    endpoint_parent: 'categories',
                    endpointChild: 'category',
                    body: {
                        category_id: category_value
                    }
                }
            }, pageNotFound);
            if ((typeof target !== 'undefined') && (document.getElementById(`${target}`).tagName.toLowerCase() == 'select')) {
                let optin_cate = document.createElement('option');
                optin_cate.setAttribute('value', 'none');
                optin_cate.appendChild(document.createTextNode('seleccione categoria'));
                document.getElementById(`${target}`).appendChild(optin_cate);
                for (let index in category.data.children_categories) {
                    // console.log(cat_pre.data[index]);
                    let item = category.data.children_categories[index];
                    optin_cate = document.createElement('option');
                    optin_cate.setAttribute('value', `${item['id']}`);
                    optin_cate.appendChild(document.createTextNode(`${item['name']}`));
                    document.getElementById(`${target}`).appendChild(optin_cate);
                }
            }
            return category;
        }

        return {
            'reject': {
                'error': 'fail_category_null',
                'code': 400,
                'cause': 'categoria no es un string o esta vacio'
            }
        }
    }, get_attributes: async (category, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        if ((typeof category === 'string') && (category.length != 0)) {
            let attr = await apiML().requestEndPoint({
                endpoint_parent: 'categories',
                endpointChild: 'attributes',
                body: {
                    category_id: item_select.value,
                }
            }, pageNotFound);
            // console.log(categories_predict);
            return attr;
        }

        return {
            'reject': {
                'error': 'fail_title',
                'code': 400,
                'cause': 'title no es un string o esta vacio'
            }
        }
    }, shipping_modes_category: async (body_data, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        if ((typeof body_data === 'object') && (body_data !== null)) {
            let attr = await apiML().requestEndPoint({
                endpoint_parent: 'users',
                endpointChild: 'shipping_modes',
                body: body_data,
            }, pageNotFound);
            // console.log(categories_predict);
            return attr;
        }

        return {
            'reject': {
                'error': 'fail_title',
                'code': 400,
                'cause': 'title no es un string o esta vacio'
            }
        }
    }, add_description_item: async (body_data, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        if ((typeof body_data === 'object') && (body_data !== null)) {
            let attr = await apiML().requestEndPoint({
                endpoint_parent: 'items',
                endpointChild: 'descritionAdd',
                body: body_data,
            }, pageNotFound);
            // console.log(categories_predict);
            return attr;
        }

        return {
            'reject': {
                'error': 'fail_title',
                'code': 400,
                'cause': 'title no es un string o esta vacio'
            }
        }
    }, sale_terms: async (pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {

        let saleTerms = await apiML().requestEndPoint({
            endpoint_parent: 'categories',
            endpointChild: 'sale_terms',
        }, pageNotFound);
        // return {
        //     'reject': {
        //         'error': 'fail_title',
        //         'code': 400,
        //         'cause': 'title no es un string o esta vacio'
        //     }
        // }
        return saleTerms;
    }, search_charts: async (name_class, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {

        let body_json = apiML(`.${name_class}`).jsontargetize();
        // console.log(body_json);
        let search_chart = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'catalog',
                endpointChild: 'searchChars',
                body: body_json,
            },
        }, pageNotFound);
        return search_chart;
    }, get_charts_attr: async (pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {

        let components_chart = null;
        let chart_attrs = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'site',
                endpointChild: 'gridSpecs',
                body: body_json,
            },
        }, pageNotFound);
        components_chart = chart_attrs.data.components[0].components;
        // return {
        //     'reject': {
        //         'error': 'fail_title',
        //         'code': 400,
        //         'cause': 'title no es un string o esta vacio'
        //     }
        // }
        return components_chart;
    }, add_chart: async (name_class, pageNotFound = { target: 'content', url: 'arethafw/html/404.html' }) => {
        let body_data = apiML(`.${name_class}`).jsontargetize();
        let response = await apiML().requestEndPoint({
            EndPoint: {
                endpoint_parent: 'site',
                endpointChild: 'createGrid',
                body: body_data,
            },
        }, pageNotFound);

        // console.log(response);
        grid_row_id = {
            "id": "SIZE_GRID_ROW_ID",
            "value_id": "11286240",
            "value_name": response.id
        }

    }, removeSiblingElements: (element, is_parent=false) => {
        
        let parent_elemt=null;
        if(is_parent){
            parent_elemt=element.nextElementSibling;
        }else{
            parent_elemt=element.parentElement.nextElementSibling;
        }
        
        while (parent_elemt) {
            parent_elemt.remove();
            if(is_parent){
                parent_elemt=element.nextElementSibling;
            }else{
                parent_elemt=element.parentElement.nextElementSibling;
            }
        }
    }
});
function loopNotiFy() {
    setInterval(() => {
        apiML('container-toast').verifyNotify();
    }, 6000);
}

apiML('container-toast').verifyNotify();
// loopNotiFy();

$('body').off('click', '#btnAcNTMl');
$('body').on('click', '#btnAcNTMl', async (e) => {
    e.preventDefault();
    let pointersEndPoint = {
        'items': {
            endpoint_parent: 'items',
            endpointChild: 'view',
        }, 'orders_v2': {
            endpoint_parent: 'orders',
            endpointChild: 'orderId',
        }, 'questions': {
            endpoint_parent: 'q&a',
            endpointChild: 'queId',
        }, 'payments': {
            endpoint_parent: 'miscl',
            endpointChild: 'payments',
        }, 'messages': {
            endpoint_parent: 'messages',
            endpointChild: 'viewFmId',
        }, 'claims': {
            endpoint_parent: 'claims',
            endpointChild: 'viewClaim',
        }, 'catalog_item_competition_status': {
            endpoint_parent: 'items',
            endpointChild: 'lossViews',
        }, 'catalog_suggestions': {
            endpoint_parent: 'catalog',
            endpointChild: 'catalogSugg',
        }, 'public_candidates': {
            endpoint_parent: 'promotions',
            endpointChild: 'candidates',
        }, 'public_offers': {
            endpoint_parent: 'promotions',
            endpointChild: 'offers',
        }
    }
    let data_resource = e.target.getAttribute('resource');
    let data_topic = e.target.getAttribute('topic');
    console.log(`data resource {${data_resource}}, data topic {${data_topic}}`);
    if (data_topic == 'messages') {
        data_resource = `/messages/${data_resource}`;
    }
    let response = apiML().requestEndPoint({
        EndPoint: {
            endpoint_parent: pointersEndPoint[data_topic].endpoint_parent,
            endpointChild: pointersEndPoint[data_topic].endpointChild,
            body: {
                resource: data_resource
            }

        },
    });
    console.log(response);
    // setTimeout(() => {
    //     e.target.parentElement.parentElement.remove()
    // }, 3000);
});