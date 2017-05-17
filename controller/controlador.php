<?php

//Se reciben todas las peticiones ajax y se responden
//Llamada del core del negocio
//include_once "../models/Productos.php";
//1..Recibe la peticion de ajax
$data = $_POST['accion'];
//2..Revisa que caso es
switch ($data) {
    case 1:
	validateAccess();
	break;
    case 2:
	getPerfiles();
	break;
    case 3:
	getCategorias();
	break;
    case 4:
	getCategorias($_POST['categoria']);
	break;
    default:
	echo "No se ha hecho ninguna peticion";
	break;
}

//3..Funciones que llamaran las funciones del DAO y devolveran los datos al ajax
function validateAccess() {
    //1.. Se consulta la tabla DAO y se guarda en una variable

    if (isset($_POST['email']) && $_POST['email'] == 'wgonzalezdi@uniminuto.edu.co' && isset($_POST['pass']) && $_POST['pass'] == '12345') {
	$json2 = array('access' => '1');
	$_SESSION['users'] = array('nombre' => 'William', 'id' => '1');
    } else {
	$json2 = array('access' => '0');
	$_SESSION['users'] = null;
    }
    //2. Se pasa a JSON para enviarla de nuevo al servidor..
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($json2);
    die();
}

function getPerfiles() {

    $json2 = array('Docente', 'Estudiante', 'Egresado', 'Administrador');
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($json2);
    die();
}

function getCategorias() {

    $json2 = array('1' => 'Territorial', '2' => 'Tecnológias e Innovadoras', '3' => 'Educación', '4' => 'Salud', '5' => 'Alimentos');
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($json2);
    die();
}

function getSubCategorias($id_categoria) {

    switch ($id_categoria) {
	case 1:
	    $json2 = array('1' => 'Relación campo -- ciudad', '2' => 'Las ciudades inclusivas y sostenibles');
	    break;
	case 2:
	    $json2 = array('1' => 'Lucha contra la corrupción', '2' => 'Lucha contra las minas quiebra patas');
	    break;
	case 3:
	    $json2 = array('1' => 'Material inclusivo para todos', '2' => 'Población desplazada - aprendizaje b-learning', '3' => 'Población que entrega las armas  -- aprendizaje b-learning', '4' => 'Formas de acceso, la calidad y la pertinencia');
	    break;
	case 4:
	    $json2 = array('1' => 'Carnetización y atención para todos', '2' => 'Diagnósticos para todos', '3' => 'Prevención de la transmisión de posibles enfermedades');
	    break;
	case 5:
	    $json2 = array('1' => 'Acces para todos de una alimentación sana y suficiente', '2' => 'Seguridad en la alimentación para todos', '3' => 'Agregación de valr a los productos');
	    break;
	default:
	    $json2 = array('1' => 'Relación campo -- ciudad', '2' => 'Las ciudades inclusivas y sostenibles');
	    break;
    }

    header('Content-type: application/json; charset=utf-8');

    echo json_encode($json2);
    die();
}
