<?php

class Categoria {

    static $id;
    static $nombre;
    static $estado;

    function Categoria() {

        $this->id	= null;
        $this->nombre	= null;
        $this->estado	= null;
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

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    //Finish Getter and Setter

}
