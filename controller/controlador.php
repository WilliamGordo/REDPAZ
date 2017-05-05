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
    default:
        echo "No se ha hecho ninguna peticion";
        break;
}

//3..Funciones que llamaran las funciones del DAO y devolveran los datos al ajax
function validateAccess() {
    //1.. Se consulta la tabla DAO y se guarda en una variable
    
    if(isset($_POST['email']) && $_POST['email'] == 'wgonzalezdi@uniminuto.edu.co' && isset($_POST['pass']) && $_POST['pass'] == '12345'){
	$json2 = array('access' => '1');
	$_SESSION['users'] = array('nombre' => 'William', 'id' => '1');
    }else{
	$json2 = array('access' => '0');
	$_SESSION['users'] = null;
    }
    //2. Se pasa a JSON para enviarla de nuevo al servidor..
    header('Content-type: application/json; charset=utf-8');

    echo json_encode($json2);
    die();
}

