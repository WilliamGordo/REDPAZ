<?php

include_once 'DAO.php';
include_once 'db_object/Categoria.php';

/**
 * Description of CategoriaManager
 *
 * @author William Gonzalez
 */
class ImplementCategorias {

    private $categoria;

    function ImplementCategorias() {
	$this->categoria = new Categoria();
    }

    function getCategorias($id_categoria = 0) {

	$auxDao = new DAO();
	$consulta = $auxDao->consultar("categorias", "id > 0 AND disabled = 0 AND parent = " . $id_categoria, "*");
	$listaCategorias = array();
	$auxDao->close();

	if (!empty($consulta)) {
	    $i = 0;
	    while ($row = $consulta->fetch()) {
		$this->categoria->setId($row['id']);
		$this->categoria->setEstado($row['disabled']);
		$this->categoria->setNombre($row['nombre']);
		$this->categoria->setParent($row['parent']);
		$categoria = $this->categoria;

		$listaCategorias[$i] = get_object_vars($categoria);
		$i++;
	    }
	} else {
	    return false;
	}
	return $listaCategorias;
    }

    function getCategoria($id_categoria) {

	$auxDao = new DAO();
	$consulta = $auxDao->consultar("categorias", "id = " . $id_categoria, "*");
	$auxDao->close();

	if (!empty($consulta)) {
	    $categoria = null;

	    while ($row = $consulta->fetch()) {
		$this->categoria->setId($row['id']);
		$this->categoria->setEstado($row['disabled']);
		$this->categoria->setNombre($row['nombre']);
		$this->categoria->setParent($row['parent']);
		$categoria = get_object_vars($this->categoria);
	    }
	    return $categoria;
	}
	return null;
    }

}
