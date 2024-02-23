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
        const response= await fetch('arethafw/plugins/ml/php/isAuthToken.php',{
            method:'POST',
            headers:{
                'Content-Type':'application/x-www-form-urlencoded'
            },
            body:JSON.stringify(confDomJson),
        });
        const data =await response.json();
        console.log(data);
        if(typeof document.getElementById(target) === 'object'){
            if('html' in data.isAuth){
                aretha(target).html(aretha(target).html()+data['isAuth']['html']);
            }else{
                return data.isAuth;
            }
        }else{
            return data.isAuth;
        }
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
    post:async(json_data,url,target_op,innet_id=false)=>{
        const response=await fetch(url,{
            method:'POST',
            headers:{
                'Content-Type': 'application/json'
            },
            body:JSON.stringify(json_data),
        });
        const data= await response.text();
        // console.log(data);
        if(innet_id){
            // console.log(typeof target_op!=="undefined");
            if( typeof target!=='undefined'){
                aretha(target).html(data);
            }else if(typeof target_op!=='undefined'){
                aretha(target_op).html(data);
            }
        }else{
            
            
            return JSON.parse(data);
        }
    },
    requestEndPoint:async(json_data)=>{
        let data=await apiML().post(json_data,'arethafw/plugins/ml/php/requestEndPoint.php');
        // console.log(data);

        if(data.status=='warning'){
            aretha('#error-title').html('Error al obtener informacion!');
            aretha('#error-body').html(`<p class="card-text">${data.endpoint_data.message}</p>`);
            document.getElementById('card-error').style.visibility='visible';

            
            setTimeout(() => {
                document.getElementById('card-error').style.visibility='hidden';
            },9000);
        }else{
            if(typeof document.getElementById(target) === 'object'){
                if(json_data.urlPage){
                    if(data.status=='success'){
                         aretha(target).html(data.html);
                         document.getElementById(target.replace('#','')).style.visibility='visible';
                    }
                }
             }
        }
       
        return data.endpoint_data;
    }
});