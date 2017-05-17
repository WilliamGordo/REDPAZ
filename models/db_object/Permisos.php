<?php

class Permisos {
    
    public $id;
    public $nombre;
    public $disabled;
    
    function Permisos(){
	$this->id		= null;
	$this->nombre		= null;
	$this->disabled		= null;
    }
    
    //Getter and Setter
    function getId() {
	return $this->id;
    }

    function getNombre() {
	return $this->nombre;
    }

    function getDisabled() {
	return $this->disabled;
    }

    function setId($id) {
	$this->id = $id;
    }

    function setNombre($nombre) {
	$this->nombre = $nombre;
    }

    function setDisabled($disabled) {
	$this->disabled = $disabled;
    }

        //Fin Getter and Setter
   
}
