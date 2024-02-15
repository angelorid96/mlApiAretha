const apiAuth=(target)=>({

    //isAuth proporciona un menu Nav utilizando bootstrap con los endpoints que quiera mostrar
    // confDomJson debera contener las siguentes llaves
    // url: si tiene un archivo template html donde esta contenido su menu
    // scope: lista de endpoints con los que se generara su menu
    // orientation: orientacion del menu si existe scope
    // En caso de no pasar ninguna de las llaves solo se generara el identificador del usurio con una serie de opciones realcionadas a este
    // defaulMenu valor booleano si decea un menu por default. si no establece orientation sera horizontal
    // Si no se incluye un identficaro de elemento ID o CLASS. no se mostrara nada.   
    isAuth:(confDomJson)=>{
        console.log('dasd');
        aretha().post('arethafw/plugins/ml/php/isAuthToken.php',JSON.stringify(confDomJson),(response)=>{
            console.log(response);
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