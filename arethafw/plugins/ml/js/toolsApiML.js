const apiAuth=(target)=>({

// confDomJson variable json que puede contener los siguientes elementos con los respectivos keys
// url -> si quiere cargar componentes especificos por medio de un archivo html o php. 
// html -> envia los componente mediante texto
// scopes -> envia un array con el nombre del id o class de los elementos para insertar los datos. asegurese de enviar el identificador del contenedor 
// de interes.
// Los indetifiacores de los elementos deben ser igual a su EndPoint para facilitar la manipulacion adecuada
// Respuesta por deafult: incluye un boton en caso de requerir autenticacion y un dropdown que incluye opciones simples
// En caso de no poder responder a un EndPoint no se agregara nada al elemento... se enviara un consol.log con el error.
    isAuth:(confDomJson)=>{
        aretha().post('arethafw/plugins/ml/php/isAuthToken.php',JSON.stringify(confDomJson),(response)=>{
            data=JSON.parse(response);
            aretha(target).html(data['isAuth']['html']);
        });
    },
    redirecAuth:()=>{
        aretha().get({
            "url":"arethafw/plugins/ml/php/isAuthToken.php",
            "data":"endpoint=auth",
            "useNotFoundPage": true,
            "notFoundPage": 'arethafw/html/404.html',
            success: function (data) {
                const response=JSON.parse(data);
                console.log(response.auth);
                if(response.auth.status=='success'){
                    // console.log(response.url);
                    window.open(response.auth.url,'_self');
                }
            },
            notfound: function (xhr) {
                aretha(target).html(xhr);
            }
        });
    }
});