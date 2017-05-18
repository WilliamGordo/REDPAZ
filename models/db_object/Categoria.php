<?php

class Categoria {

    public $id;
    public $nombre;
    public $estado;
    public $parent;

    function Categoria() {

        $this->id	= null;
        $this->nombre	= null;
        $this->estado	= null;
        $this->parent	= null;
    }

    //Getter and Setters
    
    function getId() {
	return $this->id;
    }

    function getNombre() {
	return $this->nombre;
    }

    function getEstado() {
	return $this->estado;
    }

    function getParent() {
	return $this->parent;
    }

    function setId($id) {
	$this->id = $id;
    }

    function setNombre($nombre) {
	$this->nombre = $nombre;
    }

    function setEstado($estado) {
	$this->estado = $estado;
    }

    function setParent($parent) {
	$this->parent = $parent;
    }

        
    //Finish Getter and Setter

}
