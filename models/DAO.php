<?php

include 'DataBase.php';

class DAO {

    private $connection;

    function DAO() {
	$DAO = new DataBase();
	$this->connection = $DAO->conectar();
    }

    function addUsuarios($nombre, $apellido, $email, $username, $pass, $tipo) {
	$sentencia = $this->connection->prepare("INSERT INTO usuarios ( nombres, apellidos, email, username, password, tipo_usuario) VALUES ('$nombre', '$apellido', '$email', '$username', '$pass', '$tipo')");
	$sentencia->execute();
    }

    function insertar($nombreTabla, $fila = array()) {
	
	$valoresFila = "";
	
	while (list($key, $var) = each($fila)) {
	    if ($var != null) {
		$valoresFila = $valoresFila . "'" . $var . "', ";
	    } else {
		$valoresFila .= "null, ";
	    }
	}
	$valoresFila = substr($valoresFila, 0, -2);
	$sentencia = $this->connection->prepare("INSERT INTO " . $nombreTabla . " value (" . $valoresFila . ")");
	$sentencia->execute();

	return $this->connection->lastInsertId();
    }

    function addCategorias($nombre) {
	$sentencia = $this->connection->prepare("INSERT INTO categoria ( nombre , disabled) VALUES ('$nombre', 0)");
	$sentencia->execute();
    }

    function addProductos($nombre, $img, $cantidad, $fecha) {
	$sentencia = $this->connection->prepare("INSERT INTO productos(nombre, id_categoria, cantidad, fecha_vencimiento, img) VALUES ('$nombre',1,'$cantidad','$fecha', '$img')");
	$sentencia->execute();
    }

    function consultar($nombreTabla, $condicionales, $select, $order = "", $inner = "") {

	$consulta = "SELECT " . $select . " FROM " . $nombreTabla . " " . $inner . " WHERE " . $condicionales . " ";
	if ($order != "") {
	    $consulta .= ' ORDER BY ' . $order;
	}

	$result = $this->connection->query($consulta);
	return $result;
    }

    function readById($tabla, $id) {
	$consulta = "SELECT * FROM $tabla WHERE id =$id'";
	$result = $this->connection->query($consulta);
	return $result;
    }

    function update($nombreTabla, $fields, $condicionales) {
	$sentencia2 = $this->connection->prepare("UPDATE  $nombreTabla SET " . $fields . " WHERE " . $condicionales);
	$sentencia2->execute();
	$sentencia2->fetch();
	//mysql_query("UPDATE  $nombreTabla SET " . $fields . " WHERE " . $condicionales)or die(mysql_error());
    }

    function delete($tabla, $condicionales) {
	$borrar = "DELETE FROM $tabla WHERE " . $condicionales;
	$sentencia2 = $this->connection->prepare($borrar);
	$sentencia2->execute();
	$sentencia2->fetch();
    }

    function close() {//Close conection data base
	$this->connection = null;
    }

}
