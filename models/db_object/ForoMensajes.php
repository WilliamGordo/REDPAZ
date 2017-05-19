<?php

/**
 * Description of Usuarios
 *
 * @author William Gonzalez, Miguel Trujillo, Kevin Aria
 */
class ForoMensajes{

    public $id;
    public $mensaje;
    public $created_by;
    public $created;
    public $disabled;
    public $foroP;

    function ForoMensajes() {

        $this->id		= null;
        $this->mensaje		= null;
        $this->created_by	= null;
        $this->created		= null;
        $this->disabled		= null;
        $this->foroP		= null;
    }

    //Getter and Setters
    function getId() {
	return $this->id;
    }

    function getMensaje() {
	return $this->mensaje;
    }

    function getCreated_by() {
	return $this->created_by;
    }

    function getCreated() {
	return $this->created;
    }

    function getDisabled() {
	return $this->disabled;
    }

    function getForoP() {
	return $this->foroP;
    }

    function setId($id) {
	$this->id = $id;
    }

    function setMensaje($mensaje) {
	$this->mensaje = $mensaje;
    }

    function setCreated_by($created_by) {
	$this->created_by = $created_by;
    }

    function setCreated($created) {
	$this->created = $created;
    }

    function setDisabled($disabled) {
	$this->disabled = $disabled;
    }

    function setForoP($foroP) {
	$this->foroP = $foroP;
    }

    
    //Finish Getter and Setter
    
}
