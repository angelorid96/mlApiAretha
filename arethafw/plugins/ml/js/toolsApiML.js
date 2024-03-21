/* 
    format_value retorna el valor agregar establecindo el tipo de valor y formato correspodiente 
    que se establesca mediante los valores obtenidos de los atributos
    tag_value : key del valor si la type_struct es un objecto
    value : valor a ingresar
    value_type: tipo de dato al que se debe convrtir value
    type_struc: si el formato del value debe ser un objecto o valor plano
    value_id: id del value si al atributo lo  pose. 
    id_attr: id del atributo que se agreara
    
*/
function format_value(tag_value, value, value_type, type_struct, value_id = '', id_attr = '') {
    let value_format;

    if (value_type == 'number') {
        value_format = parseInt(value);
    } else if (value_type == 'boolean') {
        value_format = (value.toLowerCase() === 'true');
    } else {
        value_format = value;
    }

    if (type_struct == 'object') {
        value_format = `"${value}"`;
        // console.log(value_format);
        if (tag_value == 'attr') {
            if (value == '') {
                return JSON.parse(`{"id":"${id_attr}","value_id":"${value_id}"}`);
            } else if (value_id == '') {
                return JSON.parse(`{"id":"${id_attr}","value_name":${value_format}}`);
            }
            return JSON.parse(`{"id":"${id_attr}","value_id":"${value_id}","value_name":${value_format}}`);
        }
        return JSON.parse(`{"${tag_value}":${value_format}}`);
    }

    return value_format;
}
function verifity_error_request_server(json_data) {
    // if(json_data.hasOwnProperty('error')){
    //     if(json_data.error='validation_error'){
    //         json.data.cause
    //     }else{

    //     }
    // }
}
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
            valid_user_authenticatio
            required_authenticatio
    */
    isAuth: async (confDomJson) => {
        const response = await fetch('arethafw/plugins/ml/php/isAuthToken.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: JSON.stringify(confDomJson),
        });
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
    },
    /*
        funcion que rediriegue a la autenticacion y autroizacion del usuario en la app
        este paso solo debe relizarce 1 vez o cuando el refresh_token expiro.
        isExpireToken.php se encarga de validar si tanto el token como refresh_token ya no son validos

    */
    redirecAuth: () => {
        aretha().get({
            "url": "arethafw/plugins/ml/php/isAuthToken.php",
            "data": "endpoint=auth",
            "useNotFoundPage": true,
            "notFoundPage": 'arethafw/html/404.html',
            success: function (data) {
                const response = JSON.parse(data);
                // console.log(response);
                if (response.urlAuth.status == 'success') {
                    // console.log(response.url);
                    window.open(response.urlAuth.url,'_self');
                }
            },
            notfound: function (xhr) {
                aretha(target).html(xhr);
            }
        });
    },
    post: async (json_data, url, target_op, innet_id = false) => {

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(json_data),
        });
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
    }, get: async (params_url, url, target_op, innet_id = false) => {
        const queryString = new URLSearchParams(params_url).toString();
        const fullUrl = `${url}?${queryString}`;

        const response = await fetch(fullUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });
        const data = await response.text();
        if (innet_id) {
            if (typeof target !== 'undefined') {
                aretha(target).html(data);
            } else if (typeof target_op !== 'undefined') {
                aretha(target_op).html(data);
            }
        } else {
            console.log(data);
            if(data.length!==0){
                return JSON.parse(data);
            }else{
                return Array();
            }
        }
    },
    requestEndPoint: async (json_data) => {
        let data = await apiML().post(json_data, 'arethafw/plugins/ml/php/requestEndPoint.php');
        // console.log(data);

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
    jsontargetize: () => {
        let json_endpoints_data = {

        };
        let id_endpoint = '';
        let type_endpoint = '';
        let key_value = '';
        let id_value = '';
        let type_value = '';
        let struct_value = '';
        let id_attr = '';
        let value_unit = '';
        let mulit_val = '';
        let select_sndata = '';

        let items;
        let insert_value = (value_name, value_id = '') => {

            let value_format = format_value(key_value, value_name + value_unit, type_value, struct_value, value_id, id_attr);

            if (type_endpoint == 'list') {
                if (!json_endpoints_data.hasOwnProperty(id_endpoint)) {
                    json_endpoints_data[id_endpoint] = [];
                }
            } else if (type_endpoint == 'object') {
                if (!json_endpoints_data.hasOwnProperty(id_endpoint)) {
                    json_endpoints_data[id_endpoint] = {};
                }
            }

            if (struct_value == 'object') {
                json_endpoints_data[id_endpoint].push(value_format);
            } else {
                if (Array.isArray(json_endpoints_data[id_endpoint])) {
                    json_endpoints_data[id_endpoint].push(value_format);
                } else if (typeof json_endpoints_data[id_endpoint] === 'object') {
                    json_endpoints_data[id_endpoint][key_value] = value_format;
                } else {
                    json_endpoints_data[id_endpoint] = value_format;
                }

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
            if (data.length != 0) {
                let container_toast=document.getElementById(target);
                let toast=null;
                data.forEach((item) => {
                    console.log(item);
                    toast=document.createElement('div');
                    toast.setAttribute('class','toast');
                    toast.setAttribute( 'role','alert');
                    toast.setAttribute('aria-live','assertive');
                    toast.setAttribute('aria-atomic','true');
                    let toast_innerHtml ='<div class="toast-header">' +
                        `<strong class="me-auto">Notifiacion ML ${item.topic}</strong>` +
                        '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
                        '</div>' +
                        '<div class="toast-body">' +
                        `<a class="btn btn-primary" role="button" resource="${data.resource}" id="btnActionToast">Ver contendo</a>`+
                        '</div>' ;
                    toast.innerHTML=toast_innerHtml;
                    container_toast.appendChild(toast);
                    const new_toats=bootstrap.Toast.getOrCreateInstance(toast);
                    new_toats.show();
                });
            }
        }
    }
});
function loopNotiFy(){
    setInterval(() => {
        apiML('container-toast').verifyNotify();
    }, 60000);
}

apiML('container-toast').verifyNotify();
loopNotiFy();
