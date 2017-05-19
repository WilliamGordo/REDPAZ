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
    eventoSelectForo();
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
		alert('Cerrando Sesión');
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
		    location.reload();
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

function eventoCrearComentario(){
    
    $('#comentForo').on('click', function(){

	var observaciones   = $('#comentarioForo').val();
	var id		    = $(this).data('id');
	var usuario	    = JSON.parse(localStorage.getItem("usuario"));
	
	$.ajax({
	    method: "POST",
	    url: "../controller/controlador.php",
	    data: {accion: 8, observaciones: observaciones, user: usuario.id, id_foro: id},
	    dataType: "json",
	    success: function (d) {

		if(d.access == 1){
		    alert('Comentario Creado Correctamente');
		    location.reload();
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

function eventoSelectForo(){
    
    $('.foros').on('click', function(){
	
	var id = $(this).attr('id');
	console.log(id);
	localStorage.setItem('foroSelect', id);
	location.reload();
    });
    
}

//Fin Eventos

function cargarForos(){
    
    if(localStorage.getItem('categorias') != '' && localStorage.getItem('categorias') != null){
	
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
		    var foroSelect = localStorage.getItem('foroSelect');
		    console.log(foroSelect);
		    $("#forosCategoriaT").show();
		    $("#btnNewForo").show();
		    $("#forosCategoria").html("");
		    $("#productoCategoria").html("");
		    
		    
		    $.each(d, function (index, item) {
			$("#forosCategoria").append('<a href="javascript:void(0)" class="list-group-item list-group-item-action foros" id="' + item.id + '">' + item.titulo + '</a>');
			if((index == d.length - 1 && foroSelect == null) || item.id == foroSelect){
			    getForoHtml(item.titulo, item.observaciones, item.created_by.nombres + ' ' + item.created_by.apellidos, item.created, item.id);
			    cargarMensajes(item.id);
			}
		    });
		    
		    eventoCrearComentario();
		    eventoSelectForo();
		}
		
	    },
	    error: function (d) {
		alert("eror: " + d);
	    }
	});
	
    }
    
}

function cargarMensajes(id_foro){
    
    $.ajax({
	method: "POST",
	url: "../controller/controlador.php",
	data: {accion: 9, foro: id_foro},
	dataType: "json",
	success: function (d) {

	    if(d.access !== 1){
		$.each(d, function (index, item) {
		    getComentariosHtml(item.created_by, item.mensaje);
		});

	    }

	},
	error: function (d) {
	    alert("eror: " + d);
	}
    });
    
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
	    
	    if(localStorage.getItem("categorias") != '' && localStorage.getItem("categorias") != null){
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
    console.log(id_categoria);
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
	    
	    if(localStorage.getItem("categorias") != '' && localStorage.getItem("categorias") != null){
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

function getForoHtml(titulo, observaciones, created_by, created, id){
    
    var htmlF = '<h2 class="text-center">' + titulo + '</h2>\n\
		<div class="form-horizontal">\n\
		    <div class="form-group">\n\
			<div class="col-md-12">\n\
			    <textarea class="form-control" disabled="disabled">' + observaciones + '</textarea>\n\
			</div>\n\
			<div class="col-md-5">\n\
			    <label>' + created_by + '</label>\n\
			</div>\n\
			<div class="col-md-2"></div>\n\
			<div class="col-md-5">\n\
			    <label>' + created + '</label>\n\
			</div>\n\
		    </div>\n\
		    <div id="comentariosForoAll"></div>\n\
		    <div class="form-group">\n\
			<div class="col-md-1"></div>\n\
			<div class="col-md-11">\n\
			    <textarea class="form-control" id="comentarioForo"></textarea>\n\
			</div>\n\
		    </div>\n\
		    <div class="form-group">\n\
			<button type="button" id="comentForo" data-id="' + id + '" class="btn btn-danger col-md-offset-10">Comentar</button>\n\
		    </div>\n\
		</div>';
    
    $('#productoCategoria').html(htmlF);
    
}

function getComentariosHtml(created_by, mensaje){
    
    var nombres = created_by.nombres.split(" ");
    var apellidos = created_by.apellidos.split(" ");
    
    var htmlF = '<div class="col-md-1"></div>\n\
		<div class="alert alert-info col-md-11">\n\
		    <strong>' + nombres[0] + ' ' +  apellidos[0] +'</strong>\n\
		    ' + mensaje + '\n\
		</div>';
    
    $('#comentariosForoAll').append(htmlF);
    
}