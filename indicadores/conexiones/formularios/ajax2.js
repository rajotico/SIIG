var ObjetoAjax;
var accion=0;
var caso=0;
/************************************************************************************************/
/*  					Funcion Para Cerrar una ventana											*/
/************************************************************************************************/
function CerrarVentana(){
	window.close();
}


/************************************************************************************************/
/*  					Funcion Para Crear un Objeto Ajax										*/
/************************************************************************************************/
function NuevoAjax(){
	var ObjetoAjax=false;
	//Para navegadores distintos a internet explorer
	try {
		ObjetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
	} 
	catch (e) {	
		try {  /*Para explorer*/
			ObjetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			ObjetoAjax = false;
	 	}
	}
	if (!ObjetoAjax && typeof XMLHttpRequest!='undefined') {
		ObjetoAjax = new XMLHttpRequest();
	}
	return ObjetoAjax; //Retornar Objeto Ajax
}

function campos(){
		accion=0;
		caso=0;
		// Crear Objeto Ajax
		ObjetoAjax=NuevoAjax();			
		// Hacer el Request y llamar o Dibujar el Resultado
		ObjetoAjax.onreadystatechange = CargarContenido;
		ObjetoAjax.open("POST", 'campos.php', true);
		ObjetoAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// Declaraci�n de par�metros

		var cant_campos= document.getElementById('cant_campos').value;
		
		var param = 'cant_campos='+cant_campos;
		ObjetoAjax.send(param);
}

function crear_tabla(){
		accion=0;
		caso=1;
		// Crear Objeto Ajax
		ObjetoAjax=NuevoAjax();			
		// Hacer el Request y llamar o Dibujar el Resultado
		ObjetoAjax.onreadystatechange = CargarContenido;
		ObjetoAjax.open("POST", 'crear_tabla.php', true);
		ObjetoAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// Declaraci�n de par�metros
		var id=document.getElementById('id').value;
		var param = 'id='+id;
		ObjetoAjax.send(param);
}


function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            theEvent.preventDefault();
	}
}

function CargarContenido(){
	// Si se Tarda en Cargar los datos que lanze los siguientes mensajes dependiendo del caso que sea	 
	if (ObjetoAjax.readyState==1) {                    
		if(accion==0)
	 		document.getElementById('resultado').innerHTML = "<center><img src='loading.gif' alt='Cargando...' /><br>Cargando Resultados...! </center>";
  	}	 // Fin Estado Cargando
	else if (ObjetoAjax.readyState == 4){//4 The request se Complet� y vamos a cargar
		if (ObjetoAjax.status == 200){//200 Significa que vamos cargar porque el request se Realiz�....!
			respuesta = ObjetoAjax.responseText;	
			document.getElementById('resultado').innerHTML='';
			/*************Dependiendo la Accion ejecutamos la Respuesta: En este caso cargar Solicitudes**************/
			if(accion==0){
				if(caso==0)
					document.getElementById('resultado').innerHTML = respuesta;
				else if(caso==1)
					document.getElementById('resultado').innerHTML = respuesta;
				else if(caso==2)
					document.getElementById('resultado2').innerHTML = respuesta;
	  		}
		}   // Fin  If Status 200
	} // Fin ReadyState 4
}// Fin de la Funcion ProcesaEsp
function cambiar(este){
aa=(este==0)?"catalogos":"catalogos1";
bb=(este==0)?"catalogos1":"catalogos";
a=document.forms[0][aa];
b=document.forms[0][bb];
if(a.value==''){return false;}
seVa=a.options[a.selectedIndex];
a[a.selectedIndex]=null;
b.options[b.options.length]=seVa;
}
function arriba() {
	obj=document.getElementById('catalogos');
	indice=obj.selectedIndex;
	if (indice>0) cambiar(obj,indice,indice-1);
		cambiar1(obj,indice,indice-1);
}
function abajo() {
	obj=document.getElementById('catalogos');
	indice=obj.selectedIndex;
	if (indice!=-1 && indice<obj.length-1)
		cambiar1(obj,indice,indice+1);
}
function cambiar1(obj,num1,num2) {
	proVal=obj.options[num1].value;
	proTex=obj.options[num1].text;
	obj.options[num1].value=obj.options[num2].value;	
	obj.options[num1].text=obj.options[num2].text;	
	obj.options[num2].value=proVal;
	obj.options[num2].text=proTex;
  obj.selectedIndex=num2;
}




//para imprimir


function xmlhttp(){
		var xmlhttp;
		try{xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");}
		catch(e){
			try{xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
			catch(e){
				try{xmlhttp = new XMLHttpRequest();}
				catch(e){
					xmlhttp = false;
				}
			}
		}
		if (!xmlhttp)
				return null;
			else
				return xmlhttp;
}//xmlhttp

function ImprimirPDF(id){
	var A = document.getElementById('salidaPDF');
		//Datos a ingresar
		var ajax = xmlhttp();
		ajax.onreadystatechange=function(){
				if(ajax.readyState==1){
				}
				if(ajax.readyState==4){
					var Respuesta=ajax.responseText;
					//window.location=Respuesta;
					A.innerHTML=Respuesta;
				}
			}
		ajax.open("GET","reportes.php?id="+id,true);
		ajax.send(null);
		return false;
}

var ObjetoAjax;
var accion=0;
var caso=0;
/************************************************************************************************/
/*  					Funcion Para Cerrar una ventana											*/
/************************************************************************************************/
function CerrarVentana(){
	window.close();
}


/************************************************************************************************/
/*  					Funcion Para Crear un Objeto Ajax										*/
/************************************************************************************************/
function NuevoAjax(){
	var ObjetoAjax=false;
	//Para navegadores distintos a internet explorer
	try {
		ObjetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e) {
		try {  /*Para explorer*/
			ObjetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			ObjetoAjax = false;
	 	}
	}
	if (!ObjetoAjax && typeof XMLHttpRequest!='undefined') {
		ObjetoAjax = new XMLHttpRequest();
	}
	return ObjetoAjax; //Retornar Objeto Ajax
}