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
                    window.open(response.urlAuth.url, '_self');
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
        // console.log(data);
        if (innet_id) {
            // console.log(typeof target_op!=="undefined");
            if (typeof target !== 'undefined') {
                aretha(target).html(data);
            } else if (typeof target_op !== 'undefined') {
                aretha(target_op).html(data);
            }
        } else {


            return JSON.parse(data);
        }
    },
    requestEndPoint: async (json_data) => {
        let data = await apiML().post(json_data, 'arethafw/plugins/ml/php/requestEndPoint.php');
        // console.log(data);

        if (data.status == 'warning') {
            aretha('#error-title').html('Error al obtener informacion!');
            aretha('#error-body').html(`<p class="card-text">${data.endpoint_data.message}</p>`);
            document.getElementById('card-error').hidden = false;


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
    jsontargetize: () => {
        let json_endpoints_data = {
            
        };
        let id_endpoint = '';
        let type_endpoint = '';
        let key_value = '';
        let value = '';
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
                let item_unit = document.getElementById(`${item_elm.id}_unit`);
                let value_unit_tmp = item_unit.options[item_unit.selectedIndex].value;
                if (value_unit_tmp.match(RegExp('[\"\']'))) {
                    value_unit = value_unit = ` \\${value_unit_tmp}`;
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
                            insert_value(item.value);
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
    }
});