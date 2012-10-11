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

function compararps(){	
		accion=0;
		caso=0;
		// Crear Objeto Ajax
		ObjetoAjax=NuevoAjax();			
		// Hacer el Request y llamar o Dibujar el Resultado
		ObjetoAjax.onreadystatechange = CargarContenido;
		ObjetoAjax.open("POST", 'compararps.php', true);
		ObjetoAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// Declaraci�n de par�metros
		var clave= document.getElementById('clave').value;
	// Concatenaci�n y Env�o de Par�metros
		var param = 'Clave='+clave;
		ObjetoAjax.send(param);
}


function comparar(){	
		accion=0;
		caso=0;
		// Crear Objeto Ajax
		ObjetoAjax=NuevoAjax();			
		// Hacer el Request y llamar o Dibujar el Resultado
		ObjetoAjax.onreadystatechange = CargarContenido;
		ObjetoAjax.open("POST", 'evaluar.php', true);
		ObjetoAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// Declaraci�n de par�metros
		if(document.getElementById('clave').value==document.getElementById('clave1').value){
    			  var valor='0';
    		}else{
    			  var valor='1';
    		}
	// Concatenaci�n y Env�o de Par�metros
		var param = 'Valor='+valor;
		ObjetoAjax.send(param);
}

function probar_conexion(){	
		accion=0;
		caso=1;
		// Crear Objeto Ajax
		ObjetoAjax=NuevoAjax();			
		// Hacer el Request y llamar o Dibujar el Resultado
		ObjetoAjax.onreadystatechange = CargarContenido;
		ObjetoAjax.open("POST", 'probar_conexion.php', true);
		ObjetoAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// Declaraci�n de par�metros
		var puerto= 		document.getElementById('puerto').value;
		var instancia=		document.getElementById('instancia').value;
		var ip= 		document.getElementById('ip').value;
		var usuario= 		document.getElementById('usuario').value;
		var clave= 		document.getElementById('clave').value;
		var nombre_base_datos= 	document.getElementById('nombre_base_datos').value;
		var id_motor= 		document.getElementById('id_motor').value;
		// Concatenaci�n y Env�o de Par�metros
		var param = 'Ip='+ip+'&Usuario='+usuario+'&Clave='+clave+'&Base='+nombre_base_datos+'&Motor='+id_motor+'&Puerto='+puerto+'&Instancia='+instancia;
		ObjetoAjax.send(param);
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
					document.getElementById('resultado1').innerHTML = respuesta;
				else if(caso==1)
					document.getElementById('resultado').innerHTML = respuesta;
				else if(caso==2)
					document.getElementById('resultado2').innerHTML = respuesta;
	  		}
		}   // Fin  If Status 200
	} // Fin ReadyState 4
}// Fin de la Funcion ProcesaEsp