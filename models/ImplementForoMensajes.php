<?php

include_once 'DAO.php';
include_once 'db_object/ForoMensajes.php';
include_once 'ImplementUsuario.php';
include_once 'ImplementForo.php';

/**
 * Description of CategoriaManager
 *
 * @author William Gonzalez
 */
class ImplementForoMensajes{

    private $foroMensaje;

    function ImplementForoMensajes() {
	$this->foroMensaje = new ForoMensajes();
    }

    function getMensajeByForo($id_foro) {

	$auxDao		    = new DAO();
	$consulta	    = $auxDao->consultar("foro_mensajes", "disabled = 0 AND id_foro = " . $id_foro, "*", 'id ASC');
	$listaForosMensaje  = array();
	$auxDao->close();
	
	if (!empty($consulta)) {
	    $i = 0;
	    while ($row = $consulta->fetch()) {
		
		$foroI	    = new ImplementForo();
		$usuarioI   = new ImplementUsuario();
		
		$this->foroMensaje->setId($row['id']);
		$this->foroMensaje->setMensaje($row['mensaje']);
		$this->foroMensaje->setCreated_by($usuarioI->getUsuariosById($row['created_by']));
		$this->foroMensaje->setCreated($row['created']);
		$this->foroMensaje->setDisabled($row['disabled']);
		$this->foroMensaje->setForoP($foroI->getForo($row['id_foro']));
		$foroMensaje = $this->foroMensaje;

		$listaForosMensaje[$i] = get_object_vars($foroMensaje);
		$i++;
	    }
	} else {
	    return null;
	}
	return $listaForosMensaje;
    }

    function addForoMensaje($mensaje, $user, $id_foro){
	
	$auxDao	    = new DAO();
	$fila	    = array(null, $mensaje, $user , date('Y-m-d'), '0', $id_foro);
	$consulta   = $auxDao->insertar('foro_mensajes', $fila);
	$auxDao->close();
	
	if (!empty($consulta)) {
	    return true;
	} else {
	    return false;
	}
	
    }
    
}
