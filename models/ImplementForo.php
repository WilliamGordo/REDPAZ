<?php

include_once 'DAO.php';
include_once 'db_object/Foro.php';
include_once 'ImplementCategorias.php';
include_once 'ImplementUsuario.php';

/**
 * Description of CategoriaManager
 *
 * @author William Gonzalez
 */
class ImplementForo{

    private $foro;

    function ImplementForo() {
	$this->foro = new Foro();
    }

    function getForoByCategoria($id_categoria) {

	$auxDao	    = new DAO();
	$consulta   = $auxDao->consultar("foro", "id > 0 AND disabled = 0 AND tema = " . $id_categoria, "*", 'id ASC');
	$listaForos  = array();
	$auxDao->close();
	
	if (!empty($consulta)) {
	    $i = 0;
	    while ($row = $consulta->fetch()) {
		
		$categoriaI = new ImplementCategorias();
		$usuarioI   = new ImplementUsuario();
		
		$this->foro->setId($row['id']);
		$this->foro->setTema($categoriaI->getCategoria($row['tema']));
		$this->foro->setTitulo($row['titulo']);
		$this->foro->setObservaciones($row['observaciones']);
		$this->foro->setCreated_by($usuarioI->getUsuariosById($row['created_by']));
		$this->foro->setCreated($row['created']);
		$this->foro->setDisabled($row['disabled']);
		$foro = $this->foro;

		$listaForos[$i] = get_object_vars($foro);
		$i++;
	    }
	} else {
	    return null;
	}
	return $listaForos;
    }

    function addForo($observaciones, $user, $categoria, $titulo){
	
	$auxDao	    = new DAO();
	$fila	    = array(null, $categoria, $titulo , $observaciones, $user, date('Y-m-d'), '0');
	$consulta   = $auxDao->insertar('foro', $fila);
	$auxDao->close();
	
	if (!empty($consulta)) {
	    return true;
	} else {
	    return false;
	}
	
    }

    function getForo($id_foro){
	
	$auxDao	    = new DAO();
	$consulta   = $auxDao->consultar("foro", "disabled = 0 AND id  = " . $id_foro, "*", 'id ASC');
	$auxDao->close();
	
	if (!empty($consulta)) {
	    $foro = null;
	    while ($row = $consulta->fetch()) {
		
		$categoriaI = new ImplementCategorias();
		$usuarioI   = new ImplementUsuario();
		
		$this->foro->setId($row['id']);
		$this->foro->setTema($categoriaI->getCategoria($row['tema']));
		$this->foro->setTitulo($row['titulo']);
		$this->foro->setObservaciones($row['observaciones']);
		$this->foro->setCreated_by($usuarioI->getUsuariosById($row['created_by']));
		$this->foro->setCreated($row['created']);
		$this->foro->setDisabled($row['disabled']);
		$foro = $this->foro;

		break;
	    }
	    return get_object_vars($foro);
	} else {
	    return null;
	}
	
    }
}
