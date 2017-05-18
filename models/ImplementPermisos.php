<?php

include_once 'DAO.php';
include_once 'db_object/Permisos.php';

/**
 * Description of CategoriaManager
 *
 * @author William Gonzalez
 */
class ImplementPermisos {

    private $permisos;

    function ImplementPermisos() {
	$this->permisos = new Permisos();
    }

    function getPermisosById($id) {

	$DAO = new DAO();
	$query = $DAO->consultar('permisos', "disabled = 0 AND id = " . $id, '*');
	$DAO->close();

	if (!empty($query)) {

	    $permisos = 0;
	    while ($row = $query->fetch()) {
		$this->permisos->setId($row['id']);
		$this->permisos->setNombre($row['nombre']);
		$this->permisos->setDisabled($row['disabled']);
		$permisos = $this->permisos;

		break;
	    }
	    return get_object_vars($permisos);
	}

	return 0;
    }

}
