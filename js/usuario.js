$(document).ready(function () {
    //Acciones que se ejecutan apenas se abre la página...
    //cargarPerfiles();
    //Acciones cuando se generan eventos.....
    eventoAccess();
    //Acciones a ejecutar cada cierto tiempo
    setInterval(validateSession(), 1200000);
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
		} else {
		    alert('Acceso Denegado');
		}
		//Se muestran los catalogos en el index

	    },
	    error: function (xhr, status) {
		alert('Usuario y Contraseña no Coinciden');
	    }

	});

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
	    $.each(d, function (index, item) {
		$("#perfiles").append("<option value='" + item.cod + "'>" + item.nombre + "</option>");
	    });
	},
	error: function (d) {
	    alert("eror: " + d);
	    waitingDialog.hide();
	}
    });
}