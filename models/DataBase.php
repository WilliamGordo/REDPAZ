<?php
//Funcion para conectar con la base de datos

class DataBase {

    private $servidor;
    private $usuario;
    private $pass;
    private $nameDB;
    private $connection;

    public function DataBase() {
        $this->servidor	    = "localhost";
        $this->usuario	    = "root";
        $this->pass	    = "";
        $this->nameDB	    = "redpaz";
	$this->connection   = null;
    }

    public function conectar() {
	
	if($this->connection == null)
        {
            try
            {
              $this->connection = new PDO("mysql:host=" . $this->servidor . ";dbname=" . $this->nameDB , $this->usuario, $this->pass);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
	
	return $this->connection;
    }
    
    function desconectar(){
	$this->connection = null;
    }
}

