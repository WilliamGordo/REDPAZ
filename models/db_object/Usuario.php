<?php

/**
 * Description of Usuarios
 *
 * @author William Gonzalez, Miguel Trujillo, Kevin Aria
 */
class Usuario {

    public $id;
    public $nombres;
    public $apellidos;
    public $correo;
    public $clave;
    public $disabled;
    public $permiso;

    function Usuario() {

        $this->id	    = null;
        $this->nombres	    = null;
        $this->apellidos    = null;
        $this->correo	    = null;
        $this->clave	    = null;
        $this->disabled	    = null;
        $this->permiso	    = null;
    }

    //Getter and Setters
    
    function getId() {
	return $this->id;
    }

    function getNombres() {
	return $this->nombres;
    }

    function getApellidos() {
	return $this->apellidos;
    }

    function getCorreo() {
	return $this->correo;
    }

    function getClave() {
	return $this->clave;
    }

    function getDisabled() {
	return $this->disabled;
    }

    function getPermiso() {
	return $this->permiso;
    }

    function setId($id) {
	$this->id = $id;
    }

    function setNombres($nombres) {
	$this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
	$this->apellidos = $apellidos;
    }

    function setCorreo($correo) {
	$this->correo = $correo;
    }

    function setClave($clave) {
	$this->clave = $clave;
    }

    function setDisabled($disabled) {
	$this->disabled = $disabled;
    }

    function setPermiso($permiso) {
	$this->permiso = $permiso;
    }

        
    //Finish Getter and Setter
    
}
