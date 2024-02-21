const apiML=(target)=>({

    //isAuth proporciona un menu Nav utilizando bootstrap con los endpoints que quiera mostrar
    // confDomJson debera contener las siguentes llaves
    // url: si tiene un archivo template html donde esta contenido su menu
    // scope: lista de endpoints con los que se generara su menu
    // orientation: orientacion del menu si existe scope
    // En caso de no pasar ninguna de las llaves solo se generara el identificador del usurio con una serie de opciones realcionadas a este
    // defaultMenu valor booleano si decea un menu por default. si no establece orientation sera horizontal
    // Si no se incluye un identficaro de elemento ID o CLASS. no se mostrara nada.   
    isAuth:async(confDomJson)=>{

        fetch('arethafw/plugins/ml/php/isAuthToken.php',{
            method:'POST',
            headers:{
                'Content-Type':'application/x-www-form-urlencoded'
            },
            body:JSON.stringify(confDomJson),
        }).then((response)=>response.json())
        .then((body)=>{
            console.log(body);
            aretha(target).html(body['isAuth']['html']);
        });  
        // const response= await fetch('arethafw/plugins/ml/php/isAuthToken.php',{
        //     method:'POST',
        //     headers:{
        //         'Content-Type':'application/x-www-form-urlencoded'
        //     },
        //     body:JSON.stringify(confDomJson),
        // });
        // const data =await response.json();

        // aretha(target).html(data['isAuth']['html']);
        
        // aretha().post('arethafw/plugins/ml/php/isAuthToken.php',JSON.stringify(confDomJson),(response)=>{
        //     console.log(response);
        // });
    },
    redirecAuth:()=>{
        aretha().get({
            "url":"arethafw/plugins/ml/php/isAuthToken.php",
            "data":"endpoint=auth",
            "useNotFoundPage": true,
            "notFoundPage": 'arethafw/html/404.html',
            success: function (data) {
                const response=JSON.parse(data);
                // console.log(response);
                if(response.urlAuth.status=='success'){
                    // console.log(response.url);
                    window.open(response.urlAuth.url,'_self');
                }
            },
            notfound: function (xhr) {
                aretha(target).html(xhr);
            }
        });
    },
    post:async(json_data)=>{
        const response=await fetch('arethafw/plugins/ml/php/requestEndPoint.php',{
            method:'POST',
            headers:{
                'Content-Type': 'application/json'
            },
            body:JSON.stringify(json_data),
        });
        // console.log(response);
       const data= await response.json();
        return data;
    },
    requestEndPoint:async(json_data)=>{
        let data=await apiML().post(json_data);
        console.log(data);

        if(data.status=='warning'){
            
        }else{
            if(typeof document.getElementById(target) === 'object'){
                if(json_data.urlPage){
                    if(data.status=='success'){
                         aretha(target).html(data.html);
                    }
                }
             }
        }
        
        return data.endpoint_data;
    }
});