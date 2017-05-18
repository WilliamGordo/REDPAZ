$(document).ready(function () {
    //Acciones que se ejecutan apenas se abre la pÃ¡gina...
    cargarDatos();
    cargarCategorias();
    cargarForos();
    //Acciones cuando se generan eventos.....
    eventoClosedSession();
    eventoCambioCategoria();
    eventoSelectTema();
    eventoNuevoForo();
    eventoCrearForo();
    //Acciones a ejecutar cada cierto tiempo
    //setInterval(validateSession(), 1200000);
});

//Eventos
function eventoClosedSession() {
    //Comienza peticion via ajax..
    $('#cerrarSesion').on('click', function () {
	var usuario = JSON.parse(localStorage.getItem("usuario"));
	localStorage.setItem("usuario", '');
	
	$.ajax({
	    method: "POST",
	    url: "../controller/controlador.php",
	    data: {accion: 5, user: usuario.id},
	    dataType: "json",
	    success: function (d) {
		alert(d);
		location.href = 'logeo.html';
	    },
	    error: function (d) {
		alert("error: " + d);
	    }
	});
	
    });

    //Termina peticion via ajax..
}

function eventoCambioCategoria() {
    //Comienza peticion via ajax..
    $('#categorias').on('change', function () {
	cargarSubCategorias($(this).val());
    });

    //Termina peticion via ajax..
}

function eventoSelectTema(){
    
    $('#setTema').on('click', function(){
	
	var categoria	    = $('#categorias').val();
	var subcategoria    = $('#subcategorias').val();

	localStorage.setItem("categorias", '{"categoria": "' + categoria + '", "subcategoria": "' + subcategoria + '"}');
	
	location.reload();
    });
    
}

function eventoNuevoForo(){
    
    $('#newForo').on('click', function(){
	
	$("#myModal").modal();
	
    });
    
}

function eventoCrearForo(){
    
    $('#createdForo').on('click', function(){

	var observaciones   = $('#observacionesForo').val();
	var titulo	    = $('#tituloForo').val();
	var usuario	    = JSON.parse(localStorage.getItem("usuario"));
	var categoria	    = JSON.parse(localStorage.getItem("categorias"));
	
	$.ajax({
	    method: "POST",
	    url: "../controller/controlador.php",
	    data: {accion: 7, observaciones: observaciones, user: usuario.id, categoria: categoria.subcategoria, title : titulo},
	    dataType: "json",
	    success: function (d) {

		if(d.access == 1){
		    alert('Foro Creado Correctamente');
		    //location.reload();
		}else{
		    alert('Error al crear el Foro');
		}
	    },
	    error: function (d) {
		alert("eror: " + d);
	    }
	});
	
    });
    
}
//Fin Eventos

function cargarForos(){
    
    if(localStorage.getItem('categorias') != ''){
	
	var categorias = JSON.parse(localStorage.getItem('categorias'));

	$.ajax({
	    method: "POST",
	    url: "../controller/controlador.php",
	    data: {accion: 6, categoria: categorias.subcategoria},
	    dataType: "json",
	    success: function (d) {
		
		if(d.access === 1){
		    $("#forosCategoriaT").show();
		    $("#btnNewForo").show();
		    $("#forosCategoria").html("<h3>Sin foros registrados</h3>");
		    $("#productoCategoria").html("<h3>No hay foros registrados</h3>");
		}else{
		    
		    $("#forosCategoriaT").show();
		    $("#btnNewForo").show();
		    $("#forosCategoria").html("");
		    $("#productoCategoria").html("");
		    
		    $.each(d, function (index, item) {
			$("#forosCategoria").append('<a href="javascript:void(0)" class="list-group-item list-group-item-action categorias" id="' + item.id + '">' + item.titulo + '</a>');
		    });
		}
		
	    },
	    error: function (d) {
		alert("eror: " + d);
	    }
	});
	
    }
    
    
}

function cargarDatos() {
    var usuario = localStorage.getItem('usuario');
    
    if (usuario.length > 0) {
	usuario = JSON.parse(usuario);
	$('#user').html('<span class="glyphicon glyphicon-user"></span>' + usuario.nombres + ' ' + usuario.apellidos);
    }else{
	location.href = 'logueo.html';
    }
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
	success: function (categorias) {
	    
	    $.each(categorias, function (index, item) {
		$("#categorias").append("<option value='" + item.id + "'>" + item.nombre + "</option>");
	    });
	    
	    if(localStorage.getItem("categorias") != ''){
		var categorias = JSON.parse(localStorage.getItem("categorias"));
		$("#categorias").val(categorias.categoria);
	    }
	    
	    cargarSubCategorias($("#categorias").val());
	},
	error: function (xhr, status) {
	    alert('Error al realizar el procedimiento');
	}
    });
}

function cargarSubCategorias(id_categoria) {
    
    if(id_categoria.length == 0){
	id_categoria = $('#categorias').val();
    }

    $.ajax({
	method: "POST",
	url: "../controller/controlador.php",
	data: {accion: 4, categoria: id_categoria},
	dataType: "json",
	success: function (d) {
	    $("#subcategorias").html("");
	    $.each(d, function (index, item) {
		$("#subcategorias").append("<option value='" + item.id + "'>" + item.nombre + "</option>");
	    });
	    
	    if(localStorage.getItem("categorias") != ''){
		var categorias = JSON.parse(localStorage.getItem("categorias"));
		console.log(categorias);
		$("#subcategorias").val(categorias.subcategoria);
	    }
	    
	},
	error: function (d) {
	    alert('Error al realizar el procedimiento');
	}
    });
}