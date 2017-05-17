$(document).ready(function () {
    //Acciones que se ejecutan apenas se abre la pÃ¡gina...
    cargarDatos();
    cargarCategorias();
    //Acciones cuando se generan eventos.....
    eventoClosedSession();
    //Acciones a ejecutar cada cierto tiempo
    //setInterval(validateSession(), 1200000);
});

function cargarDatos(){
    var usuario = localStorage.getItem('usuario');
    
    if(usuario.length > 0){
	usuario = JSON.parse(usuario);
	$('#user').html('<span class="glyphicon glyphicon-user"></span>' + usuario.nombres + ' ' + usuario.apellidos);
    }
}

function eventoClosedSession() {
    //Comienza peticion via ajax..
    $('#cerrarSesion').on('click', function () {

	localStorage.setItem("usuario", '');
	location.href ='logeo.html';
	
    });

    //Termina peticion via ajax..
}

function cargarPerfiles() {
    $.ajax({
	method: "POST",
	url: "../controller/controlador.php",
	data: {accion: 2},
	dataType: "json",
	success: function (d) {
	    console.log(d);
	    $.each(d, function (index, item) {
		$("#perfiles").append("<option value='" + index + "'>" + item + "</option>");
	    });
	},
	error: function (d) {
	    alert("eror: " + d);
	    waitingDialog.hide();
	}
    });
}

function cargarCategorias() {
    $.ajax({
	method: "POST",
	url: "../controller/controlador.php",
	data: {accion: 3},
	dataType: "json",
	success: function (d) {
 	   $.each(d, function (index, item) {
		$("#categorias").append("<option value='" + index + "'>" + item + "</option>");
	    });
	    
	    cargarSubCategorias();
	},
	error: function (d) {
	    alert("eror: " + d);
	    waitingDialog.hide();
	}
    });
}

function cargarSubCategorias() {
    var id_categoria = $('#categorias').val();
    
    $.ajax({
	method: "POST",
	url: "../controller/controlador.php",
	data: {accion: 4, categoria: id_categoria},
	dataType: "json",
	success: function (d) {
 	   $.each(d, function (index, item) {
		$("#subcategorias").append("<option value='" + index + "'>" + item + "</option>");
	    });
	},
	error: function (d) {
	    alert("eror: " + d);
	    waitingDialog.hide();
	}
    });
}