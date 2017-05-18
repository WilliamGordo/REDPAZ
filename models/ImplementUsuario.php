<?php

include_once 'DAO.php';
include_once 'ImplementPermisos.php';
include_once 'db_object/usuario.php';

/**
 * Description of CategoriaManager
 *
 * @author William Gonzalez
 */
class ImplementUsuario {

    private $usuario;

    function ImplementUsuario() {
	$this->usuario = new Usuario();
    }

    function getAllUsuarios() {
	$auxDao = new DAO();
	$consulta = $auxDao->consultar("usuarios", "id > 0", "*");
	$listaUsuarios = array();
	$auxDao->close();
	if (!empty($consulta)) {
	    $i = 0;
	    while ($row = $consulta->fetch()) {
		$listaUsuario = new Usuario();
		$listaUsuario->setId($row['id']);
		$listaUsuario->setNombres($row['nombres']);
		$listaUsuario->setApellidos($row['apellidos']);
		$listaUsuario->setEmail($row['email']);
		$listaUsuario->setUsername($row['username']);
		$listaUsuario->setPassword($row['password']);
		$listaUsuario->setTipo_usuario($row['tipo_usuario']);
		$listaUsuarios[$i] = get_object_vars($listaUsuario);
		$i++;
	    }
	}
	return $listaUsuarios;
    }

    function validarUser($email, $pass) {

	$DAO = new DAO();
	$query = $DAO->consultar('usuarios', "correo = '" . $email . "' AND clave = '" . $pass . "' AND disabled = 0", '*');
	$DAO->close();

	if (!empty($query)) {

	    $usuario = 0;

	    while ($row = $query->fetch()) {

		$permisosI = new ImplementPermisos();

		$this->usuario->setId($row['id']);
		$this->usuario->setNombres($row['nombres']);
		$this->usuario->setApellidos($row['apellidos']);
		$this->usuario->setCorreo($row['correo']);
		$this->usuario->setDisabled($row['disabled']);
		$this->usuario->setClave('');
		$this->usuario->setPermiso($permisosI->getPermisosById($row['id_permiso']));
		$usuario = $this->usuario;
		
		$this->setUsuarioActivo($row['id']);
		
		break;
	    }
	    return get_object_vars($usuario);
	}

	return 0;
    }

    function setUsuarioActivo($id, $activo = 1, $date = true){
	
	if($date === true){
	    $date = date('Y-m-d');
	}
	
	$DAO = new DAO();
	$query = $DAO->update('usuarios', 'activo = ' . $activo . ', date_access = \'' . $date . '\'', 'id = ' . $id);
	$DAO->close();
	
    }
    
    function deleteUsuarioById($id) {
	$DAO = new DAO();
	$query = $DAO->delete('usuarios', "id = " . $id);
	$DAO->close();
    }

    function getUsuariosById($id) {
	
	$DAO = new DAO();
	$query = $DAO->consultar('usuarios', 'id = ' . $id, '*');
	$DAO->close();
	
	if (!empty($query)) {
	    
	    $usuario = null;
	    while ($row = $query->fetch()) {
		$permisosI = new ImplementPermisos();

		$this->usuario->setId($row['id']);
		$this->usuario->setNombres($row['nombres']);
		$this->usuario->setApellidos($row['apellidos']);
		$this->usuario->setCorreo($row['correo']);
		$this->usuario->setDisabled($row['disabled']);
		$this->usuario->setClave('');
		$this->usuario->setPermiso($permisosI->getPermisosById($row['id_permiso']));
		$usuario = $this->usuario;
		
		break;
	    }
	    
	    return get_object_vars($usuario);
	}

	return null;
    }

    function addUsuarios($nombre, $apellido, $email, $username, $pass, $tipo) {
	$DAO = new DAO();
	$query = $DAO->addUsuarios($nombre, $apellido, $email, $username, $pass, $tipo);
	$DAO->close();
    }

    function registrarUsuarios($nombre, $apellido, $email, $username, $pass, $tipo) {
	$DAO = new DAO();
	$query = $DAO->addUsuarios($nombre, $apellido, $email, $username, $pass, $tipo);
	$DAO->close();
    }

}
