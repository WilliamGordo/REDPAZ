<?php

//Se reciben todas las peticiones ajax y se responden
//Llamada del core del negocio
include_once "../models/ImplementUsuario.php";
include_once "../models/ImplementCategorias.php";
include_once "../models/ImplementForo.php";
//1..Recibe la peticion de ajax
$data = $_POST['accion'];
//2..Revisa que caso es
switch ($data) {
    case 1:
	validateAccess($_POST['email'], $_POST['pass']);
	break;
    case 2:
	getPerfiles();
	break;
    case 3:
	getCategorias();
	break;
    case 4:
	getSubCategorias($_POST['categoria']);
	break;
    case 5:
	setUsuarioActivo($_POST['user']);
	break;
    case 6:
	getForoCategoria($_POST['categoria']);
	break;
    case 7:
	setForo($_POST['observaciones'], $_POST['user'], $_POST['categoria'], $_POST['title']);
	break;
    default:
	echo "No se ha hecho ninguna peticion";
	break;
}

//3..Funciones que llamaran las funciones del DAO y devolveran los datos al ajax
function validateAccess($email, $pass) {
    //1.. Se consulta la tabla DAO y se guarda en una variable
    $usuarioImple   = new ImplementUsuario();
    $acceso	    = $usuarioImple->validarUser($email, $pass);

    if(!is_array($acceso) && $acceso === false){
	$acceso['access'] = 1;
    }
    //2. Se pasa a JSON para enviarla de nuevo al servidor..
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($acceso);
    die();
}

function getPerfiles() {

    $json2 = array('Docente', 'Estudiante', 'Egresado', 'Administrador');
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($json2);
    die();
}

function getCategorias() {

    $categoriasI = new ImplementCategorias();
    $datos = $categoriasI->getCategorias();

    if($datos === false){
	$datos = array('Error' => 0);
    }
    
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($datos);
    die();
}

function getSubCategorias($id_categoria) {

    $categoriasI = new ImplementCategorias();
    $datos = $categoriasI->getCategorias($id_categoria);
    
    if($datos === false){
	$datos = array('Error' => 0);
    }

    header('Content-type: application/json; charset=utf-8');

    echo json_encode($datos);
    die();
}

function setUsuarioActivo($id_user){
    
    $usuarioImple   = new ImplementUsuario();
    $usuarioImple->setUsuarioActivo($id_user, 0, '0000-00-00');
    
    header('Content-type: application/json; charset=utf-8');
    
    echo json_encode(array('access' => '1'));
    die();
}

function getForoCategoria($categoria){
    
    $foroI = new ImplementForo();
    
    $foros = $foroI->getForoByCategoria($categoria);

    if(empty($foros)){
	$foros['access'] = 1;
    }
    //2. Se pasa a JSON para enviarla de nuevo al servidor..
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($foros);
    die();
    
}

function setForo($observaciones, $user, $categoria, $titulo){
    
    $foroI = new ImplementForo();
    
    $bool = $foroI->addForo($observaciones, $user, $categoria, $titulo);
    
    if($bool === true){
	$json = array('access' => 1);
    }else{
	$json = array('access' => 0);
    }
    
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($json);
    die();
    
}