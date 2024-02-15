//BEGIN AJUSTE DECIMAL
(function() {
	getTypeElem = function(obj){
		if ($(obj).length) {
			return $(obj)[0].tagName == "INPUT" ? $(obj)[0].type.toLowerCase() : $(obj)[0].tagName.toLowerCase();
		}
		return "";
	}
	
	/**
	* Ajuste decimal de un número.
	*
	* @param {String}  tipo  El tipo de ajuste.
	* @param {Number}  valor El numero.
	* @param {Integer} exp   El exponente (el logaritmo 10 del ajuste base).
	* @returns {Number} El valor ajustado.
	*/
	function decimalAdjust(type, value, exp) {
		// Si el exp no está definido o es cero...
		if (typeof exp === 'undefined' || +exp === 0) {
			return Math[type](value);
		}
		value = +value;
		exp   = +exp;
		
		// Si el valor no es un número o el exp no es un entero...
		if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
			return NaN;
		}
		
		// Shift
		value = value.toString().split('e');
		value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
		
		// Shift back
		value = value.toString().split('e');
		return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
	}

	// Decimal round
	if (!Math.round10) {
		Math.round10 = function(value, exp) {
			return decimalAdjust('round', value, exp);
		};
	}
	
	// Decimal floor
	if (!Math.floor10) {
		Math.floor10 = function(value, exp) {
			return decimalAdjust('floor', value, exp);
		};
	}
	
	// Decimal ceil
	if (!Math.ceil10) {
		Math.ceil10 = function(value, exp) {
			return decimalAdjust('ceil', value, exp);
		};
	}
})();

// Función para truncar y redondear
function decimalConvert(cant, numDec = 6, truncRed = 2){
	var cant = cant * 1;
	var splt = (cant+"").split(".");
	cant = cant.toFixed(6);

	if (truncRed == 1) { // 1 trunca 2 redondea
		var fact = Math.pow(10, numDec);
		return parseInt(cant * fact) / fact;
	}else{
		var fact = Math.pow(10, numDec);
		return Math.round10(((cant * fact) / fact), ((numDec)*(-1)));
	}
	
	return cant;
}
//END AJUSTE DECIMAL

function detectSO(){
	let os = "Unknown";
	if (navigator.appVersion.indexOf("Win")   != -1) os = "Windows";
	if (navigator.appVersion.indexOf("Mac")   != -1) os = "MacOS";
	if (navigator.appVersion.indexOf("X11")   != -1) os = "UNIX";
	if (navigator.appVersion.indexOf("Linux") != -1) os = "Linux";
	
	return os;
}

var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
    isMobile = true;
}

//BEGIN CLIPBOARD
$("body").off("click", ".clss_glob_clipboard");
$("body").on("click", ".clss_glob_clipboard", function(e){
	var txt_copiar = $.trim($(this).data("clipboard"));
	var parentClss = $(this).parent();
	var $temp = $("<input>");
	$(parentClss).append($temp);
	$temp.val(txt_copiar).select();
	document.execCommand("Copy", false, null);
	alert("Copiando " + txt_copiar);
	$temp.remove();
});
//END CLIPBOARD

//BEGIN VALIDA RFC
function validRFC(rfcStr) {
	var rfc_pattern_pm = "^(([A-ZÑ&]{3})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{2}[0-9A]))|" +
                                             "(([A-ZÑ&]{3})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{2}[0-9A]))|" +
                                             "(([A-ZÑ&]{3})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{2}[0-9A]))|" +
                                             "(([A-ZÑ&]{3})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{2}[0-9A]))$";
	var rfc_pattern_pf = "^(([A-ZÑ&]{4})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{2}[0-9A]))|" +
									   "(([A-ZÑ&]{4})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{2}[0-9A]))|" +
									   "(([A-ZÑ&]{4})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{2}[0-9A]))|" +
									   "(([A-ZÑ&]{4})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{2}[0-9A]))$";
	
	var pattern = "";
	if (rfcStr.length == 12) {
		pattern = rfc_pattern_pm;
	} else {
		pattern = rfc_pattern_pf;
	}
	
	var validar = new RegExp(pattern);
	var matchArray = rfcStr.match(validar);
	
	if (matchArray == null) {
		return false;
	}
	
	return true;
}
//END VALIDA RFC

//BEGIN VALIDA CURP
function validCURP(curpStr) {
	var pattern = '[A-Z][A,E,I,O,U,X][A-Z]{2}' +
				'[0-9]{2}[0-1][0-9][0-3][0-9]' +
				'[M,H]' +
				'[A-Z]{2}' +
				'[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}' +
				'[0-9,A-Z][0-9]$';
	
	var validar = new RegExp(pattern);
	var matchArray = curpStr.match(validar);
	if (matchArray == null) {
		return false;
	}
	return true;
}
//END VALIDA CURP

//BEGIN VALIDA EMAIL
function validEmail(valor) {
	var reg        = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-z\-0-9]+\.)+[a-z]{2,}))$/;
	var reg2       = /[^\s@]+@[^\s@]+\.[^\s@]+/g;
	var regOficial = /^[a-z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?(?:\.[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?)*$/;

	if (reg.test(valor) && regOficial.test(valor)) {
		return true;
	} 
	else if (reg.test(valor)) {
		return true;
	}
	else {
		return false;
	}
	return false;
}
//END VALIDA EMAIL

String.prototype.toHtmlEntities = function() {
    return this.replace(/./gm, function(s) {
        return "&#" + s.charCodeAt(0) + ";";
    });
};

function validURL(str) {
  var pattern = /^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/;
  return pattern.test(str);
}

function isURL(str) {
	try {
		const newUrl = new URL(str);
		return newUrl.protocol === 'http:' || newUrl.protocol === 'https:';
	} catch (err) {
		return false;
	}
}

// BEGIN FUNCION PARA DAR FORMATO DE MONEDA A CANTIDADES
function formatN(cant, numDec) {
	formatter = new Intl.NumberFormat('MXN', {
	  style: 'currency',
	  currency: 'MXN',
	  minimumFractionDigits: numDec,
	  maximumFractionDigits: numDec
	});
	
	return formatter.format(cant);
}

function numFormat(number){
	var numDec 	  = 2;
	var auxNumber = $.trim(""+number);
	var hayDecim  = auxNumber.indexOf(".");
	
	if (hayDecim != -1) {
		var cantidadS 	 = auxNumber.split(".");
		var valorDecimal = ""+cantidadS[1];
		numDec = valorDecimal.length;
	}
	
	numberConvert = number;
	numberConvert = $.trim(formatN(number, numDec));
	numberConvert = numberConvert.replace("$", "");
	return numberConvert;
}
// END FUNCION PARA DAR FORMATO DE MONEDA A CANTIDADES

//BEGIN sección para quitar el drop a todos los inputs en los que se pueda escribir
var arrElmText = new Array(
	'input[type="email"]',
	'input[type="month"]',
	'input[type="number"]',
	'input[type="password"]',
	'input[type="search"]',
	'input[type="tel"]',
	'input[type="text"]',
	'input[type="url"]',
	'input[type="week"]',
	'textarea'
);

arrElmText.forEach(function (elem, index) {
	$("body").off("copy", elem+':not(.enacopy)');
	$("body").on("copy", elem+':not(.enacopy)', function(e) {
		return false;
	});
	
	//$("body").off("paste", elem+':not(.enapaste)');
	//$("body").on("paste", elem+':not(.enapaste)', function(e) {
	//	return false;
	//});
	
	$("body").off("cut", elem+':not(.enacut)');
	$("body").on("cut", elem+':not(.enacut)', function(e) {
		return false;
	});
	
	$("body").off("drop", elem+':not(.enadrop)');
	$("body").on("drop", elem+':not(.enadrop)', function(e) {
		return false;
	});
	
	// aplicar solo a mobiles
	if(isMobile){
		if (elem != 'input[type="number"]') {
			$("body").off("keydown keypress keyup blur",  elem+':not(.enamxlng)');
			$("body").on("keydown keypress keyup blur",  elem+':not(.enamxlng)', function(evt){
				let elem = $(this);
				let elemVal = $(elem).val();
				let txtLngt = $(elem).attr("maxlength");
				
				if (typeof txtLngt !== 'undefined') {
					let lengVal = elemVal.length;
					if (lengVal > txtLngt) {
						elemVal = elemVal.slice(0, txtLngt);
					}				
				}
				
				$(elem).val(elemVal);
			});		
		}		
	}
});
//END sección para quitar el drop a todos los inputs en los que se pueda escribir

//BEGIN Sección que reemplaza caracteres utilizando expresiones regulares
var ptnVcls = "\sÁÉÍÓÚÝáéíóúýÀÈÌÒÙàèìòùÂÊÎÔÛâêîôûÄËÏÖÜäëïöü";
if (detectSO() == "MacOS") {
	ptnVcls = "\sÁÉÍÓÚÝáéíóúýÀÈÌÒÙàèìòùÂÊÎÔÛâêîôûÄËÏÖÜäëïöü´";
}

var arrRgx = {
	'EMAIL'                     : "/[^a-zA-Z0-9.@_\-]/g",
	'RFC'                       : "/[^a-zA-Z0-9\s&Ññ]/g",
	'ONLY_NUMBERS'              : "/[^0-9]/g",
	'NUMBERS_HYPHENS'           : "/[^0-9\-]/g",
	'POINT_NUMBERS'             : "/[^0-9.]/g",
	'ONLY_KEYS'                 : "/[^a-zA-Z0-9\sÑñ_\- ]/g",
	'CHARS_COUPON'              : "/[^a-zA-Z0-9\sÑñ_\-]/g",
	'CHARS_PASSWORD'            : "(/[\"'\/\\´]/g",
	'NO_SPECIAL_CHARS'          : "/[^a-zA-Z0-9" + ptnVcls + "Ññª ]/g",
	'NO_SPECIAL_CHARS_EXCEPTION': "/[^a-zA-Z0-9" + ptnVcls + "Ññª!¡¿?,._;:() -]/g",
	'ONLY_LETTERS'              : "/[^a-zA-Z"    + ptnVcls + "Ññª ]/g",
	'CHARS_ADDRESS'             : "/[^a-zA-Z0-9" + ptnVcls + "Ññ .&#-]/g",
	'CHARS_RAZ_SOC'             : "/[^a-zA-Z0-9" + ptnVcls + "Ññª&. ]/g",
	'CHARS_NAME'                : "/[^a-zA-Z0-9" + ptnVcls + "Ññ+_.&¡!¿?, -]/g",
	'CHARS_ADICIONAL_INF'       : "/[^a-zA-Z0-9" + ptnVcls + "Ññª. ]/g",
	'RATE_NAME'                 : "/[^a-zA-Z0-9" + ptnVcls + "Ññª -]/g",
	'DOMAIN'                    : "/[^a-zA-Z0-9\-Ññ]/g",
	'QWERTY_EN'                 : "/[^a-zA-Z ]/g",
	'PLATES'                    : "/[^a-zA-Z0-9\-]/g",
	'SPACE_NUMBERS'             : "/[^0-9 ]/g",
};

function replaceStr(str, rgxId){
	let rgx = arrRgx[rgxId];
	
	if (typeof rgx !== 'undefined') {
		str = str.replace(eval(rgx), '');
	}
	
	return str;
}

function evalRgx(strVal, rgxId){
	let valRepl = replaceStr(strVal, rgxId);
	
	if (strVal == valRepl) {
		return true;
	}
	return false;
}

$("body").off("keydown keypress keyup blur", ".glob_regex:not(select)");
$("body").on("keydown keypress keyup blur", ".glob_regex:not(select)", function(evt){
	let elem   = $(this);
	let elmStr = $(elem).val();
	let rgxId  = $(elem).data("regex");

	let alertCR=$('#cralert');

	// console.log("probando...");
	// console.log(alertCR.html("No se aceptan caracteres"));
	if (typeof rgxId !== 'undefined') {
		elmStr = replaceStr(elmStr, rgxId);
		$(elem).val(elmStr);
	}
});
//END Sección que reemplaza caracteres utilizando expresiones regulares

//BEGIN SOLO NÚMEROS
$("body").off("keydown keypress keyup", ".clss_glob_numbers");
$("body").on("keydown keypress keyup", ".clss_glob_numbers", function(evt){
	if (evt.shiftKey) {
		evt.preventDefault();
	}
	
	var charCode = (evt.which) ? evt.which : event.keyCode;
	
	// backspace, key right, key left
	if (charCode == 8 || charCode == 37 || charCode == 39) {
		return true;
	} else if(charCode >= 48 && charCode <= 57) { // is a number.
		return true;
	} else if(charCode >= 96 && charCode <= 105) { // is a number.
		return true;
	} else { // other keys.
		return false;
	}
});
//END SOLO NÚMEROS

//BEGIN NÚMEROS DECIMALES
globalGeneral = 0;
var ctrlDownG = false; 
var ctrlKeyG  = 17, vKeyG = 86, cKeyG = 67; 

$(document).keydown(function(e) { 
	if (e.keyCode == ctrlKeyG) ctrlDownG = true; 
}).keyup(function(e) { 
	if (e.keyCode == ctrlKeyG) ctrlDownG = false; 
});

$("body").off("keydown", ".clss_glob_numeric");
$("body").on("keydown", ".clss_glob_numeric", function(e) {
	if (ctrlDownG && (e.keyCode == vKeyG || e.keyCode == cKeyG)) {
		return false; 
	}
}); 

$("body").off("keypress", ".clss_glob_numeric");
$("body").on("keypress", ".clss_glob_numeric", function(event) {
	 if (event.which == 8 || event.which == 0) {
		 return true;
	 }
	 if ((event.which != 46) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	 }
});

$("body").off("focus", ".clss_glob_numeric");
$("body").on("focus", ".clss_glob_numeric", function(event){
	var cantid = $( this ).val();
	var objId  = $( this ).attr('id');
	globalGeneral = cantid;
});

$("body").off("keyup blur", ".clss_glob_numeric:not(select)");
$("body").on("keyup blur", ".clss_glob_numeric:not(select)", function(event){
	var numDec 	  = $(this).data("num-dec"); // numDec => numero de decimales permitidos
	var objId  	  = $( this ).attr('id');
	var cantid 	  = $( this ).val();
	var decim  	  = ($( this ).val()).split(".");
	var totPuntos = (decim.length - 1);
	
	if(decim.length > 1){
		if(decim[1].length > numDec){
			cantid = globalGeneral;
			$(this).val(cantid);
		}
	}	
	if(totPuntos > 1){
		cantid = globalGeneral;
		$(this).val(cantid);
	}
	
	globalGeneral = cantid;
});	

//END NÚMEROS DECIMALES

//BEGIN FUNCIONES PARA EVITAR COPIAR, PEGAR, CORTAR Y ARRASTRAR
$("body").off("copy", ".clss_glob-no-copy");
$("body").on("copy", ".clss_glob-no-copy", function(e) {
	return false;
});

$("body").off('paste', '.clss_glob-no-paste');
$("body").on('paste', '.clss_glob-no-paste', function(e) {
	return false;
});

$("body").off('cut', '.clss_glob-no-cut');
$("body").on('cut', '.clss_glob-no-cut', function(e) {
	return false;
});

$("body").off("drop", '.clss_glob-no-drop');
$("body").on("drop", '.clss_glob-no-drop', function(e) {
	return false;
});	
//END FUNCIONES PARA EVITAR COPIAR, PEGAR, CORTAR Y ARRASTRAR

//BEGIN FUNCIONES PARA MAYUSCULAS A MINUSCULAS Y VICEVERSA
//mayusculas
$('body').off("keyup", ".clss_glob-font-upper");
$('body').on("keyup", ".clss_glob-font-upper", function(event) {
	$(this).val($(this).val().toUpperCase());
});

//minusculas
$('body').off("keyup", ".clss_glob-font-lower");
$('body').on("keyup", ".clss_glob-font-lower", function(event) {
	$(this).val($(this).val().toLowerCase());
});
//END FUNCIONES PARA MAYUSCULAS A MINUSCULAS Y VICEVERSA

//BEGIN PREVENT DEFAULT
$("body").off("click", ".clss_glob_prev_def");
$("body").on("click", ".clss_glob_prev_def", function(e){
	e.preventDefault();
});
//END  PREVENT DEFAULT

//BEGIN CAMBIA EL TIPO DE INPUT
$("body").off("click", ".clss_glob_change_type");
$("body").on("click", ".clss_glob_change_type", function(e){
	var elem     = $(this)
	var auxInput = $(elem).data("input");
	var iconTxt  = $(elem).data("icon_txt");
	var iconPsw  = $(elem).data("icon_psw");
	var auxType  = getTypeElem(auxInput);
	
	if (auxType == "text") {
		$(auxInput).attr('type', 'password');
		$(elem).find("i").removeClass(iconPsw).addClass(iconTxt);
	}
	
	if (auxType == "password") {
		$(auxInput).attr('type', 'text');
		$(elem).find("i").removeClass(iconTxt).addClass(iconPsw);
	}
});
//END CAMBIA EL TIPO DE INPUT

$("body").off("keydown keypress keyup blur", ".maxlength_number:not(select)");
$("body").on("keydown keypress keyup blur", ".maxlength_number:not(select)", function(evt){
	let objImpt = $(this);
	let txtNumb = $(objImpt).val();
	let txtLngt = $(objImpt).attr("maxlength");
	
	if (typeof txtLngt !== 'undefined') {
		let lengVal = txtNumb.length;
		if (lengVal > txtLngt) {
			txtNumb = txtNumb.slice(0, txtLngt);
		}				
	}
	
	$(objImpt).val(txtNumb);
});

$("body").off("wheel.disableScroll", ".clss_glob_noscroll");
$("body").on("wheel.disableScroll", ".clss_glob_noscroll", function(evt){
	evt.preventDefault();
	$(this).blur();
});

// BEGIN SECCIÓN PARA ENCONTRAR EL IDENTIFICADOR DE UN ELEMENTO PADRE A PARTIR DE UN ELEMENTO HIJO Y UNA CLASE
function getIdRoot(elem, className){
	var auxElem = $(elem).parent()[0];
	
	if (className == "") {
		return $("body");
	}
	
	if (auxElem.nodeName == "BODY") {
		return $("body");
	}
	
	if ($(auxElem).hasClass(className) == false) {
		return getIdRoot(auxElem, className);
	}
	
	return $(auxElem);
}
// END SECCIÓN PARA ENCONTRAR EL IDENTIFICADOR DE UN ELEMENTO PADRE A PARTIR DE UN ELEMENTO HIJO Y UNA CLASE