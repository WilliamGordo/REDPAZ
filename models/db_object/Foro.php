<?php

/**
 * Description of Usuarios
 *
 * @author William Gonzalez, Miguel Trujillo, Kevin Aria
 */
class Foro{

    public $id;
    public $tema;
    public $titulo;
    public $observaciones;
    public $created_by;
    public $created;
    public $disabled;

    function Foro() {

        $this->id		= null;
        $this->tema		= null;
        $this->titulo		= null;
        $this->observaciones    = null;
        $this->created_by	= null;
        $this->created		= null;
        $this->disabled		= null;
    }

    //Getter and Setters
    function getId() {
	return $this->id;
    }

    function getTema() {
	return $this->tema;
    }

    function getObservaciones() {
	return $this->observaciones;
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

    function setId($id) {
	$this->id = $id;
    }

    function setTema($tema) {
	$this->tema = $tema;
    }

    function setObservaciones($observaciones) {
	$this->observaciones = $observaciones;
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
    
    function getTitulo() {
	return $this->titulo;
    }

    function setTitulo($titulo) {
	$this->titulo = $titulo;
    }

        
        //Finish Getter and Setter
    
}
