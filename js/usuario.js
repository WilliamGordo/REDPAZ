$(document).ready(function () {
    //Acciones que se ejecutan apenas se abre la pÃ¡gina...
    cargarPerfiles();
    cargarCategorias();
    //Acciones cuando se generan eventos.....
    eventoAccess();
    eventoClosedSession();
    //Acciones a ejecutar cada cierto tiempo
    //setInterval(validateSession(), 1200000);
});

function eventoAccess() {
    //Comienza peticion via ajax..
    $('#access').on('click', function () {

	var email = $('#email').val();
	var password = $('#pwd').val();

	$.ajax({
	    url: '../controller/controlador.php',
	    data: {accion: 1, email: email, pass: password},
	    type: 'POST',
	    dataType: 'JSON',
	    success: function (dataAccess) {
		if (dataAccess.access == 1) {
		    alert('Acceso Satisfactorio');
		    $('#logueo').hide();
		    $('#tema').show();
		} else {
		    alert('Acceso Denegado');
		}
		//Se muestran los catalogos en el index

	    },
	    error: function (xhr, status) {
		alert('Usuario y ContraseÃ±a no Coinciden');
	    }

	});

    });

    //Termina peticion via ajax..
}

function eventoClosedSession() {
    //Comienza peticion via ajax..
    $('#closeSession').on('click', function () {

	$('#tema').hide();
	$('#logueo').show();
	
	/*Cierre de sesion*/
//	$.ajax({
//	    url: '../controller/controlador.php',
//	    data: {accion: 1, email: email, pass: password},
//	    type: 'POST',
//	    dataType: 'JSON',
//	    success: function (dataAccess) {
//		if (dataAccess.access == 1) {
//		    alert('Acceso Satisfactorio');
//		    $('#logueo').hide();
//		    $('#tema').show();
//		} else {
//		    alert('Acceso Denegado');
//		}
//		//Se muestran los catalogos en el index
//
//	    },
//	    error: function (xhr, status) {
//		alert('Usuario y ContraseÃ±a no Coinciden');
//	    }
//
//	});

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