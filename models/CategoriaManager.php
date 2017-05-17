<?php

include_once 'DAO.php';
include_once 'db_object/Categoria.php';
/**
 * Description of CategoriaManager
 *
 * @author William Gonzalez
 */
class CategoriaManager {
    
    private $categoria;
    
    function CategoriaManager(){
	$this->categoria = new Categoria();
    }
    
    function getCategoria() {
	return $this->categoria;
    }

    function setCategoria($categoria) {
	$this->categoria = $categoria;
    }

    function getAllCategorias() {
        
	$auxDao	    = new DAO();       
        $consulta   = $auxDao->consultar("categoria", "id > 0", "*");
        $categorias = array();
        $auxDao->close();
        if (!empty($consulta)) {
            $i = 0;
            while ($row = $consulta->fetch()) {

		$categoria = new Categoria();
                $categoria->setId($row['id']);
                $categoria->setNombre($row['nombre']);
                $categoria->setEstado($row['disabled']);
		$this->setCategoria($categoria);
		
                $categorias[$i] = get_object_vars($this->getCategoria());
                $i++;
            }
        }
        return $categorias;
	
    }

    function deleteCategoriaById($id) {
        $DAO = new DAO();
        $query = $DAO->delete('categoria', "id = " . $id);
        $DAO->close();
    }
    
    function getCategoriasById($id) {
    
	$auxDao	    = new DAO();       
        $consulta   = $auxDao->consultar('categoria', 'id = ' . $id, '*');
        $auxDao->close();
	
        if (!empty($consulta)) {
            while ($row = $consulta->fetch()) {
                $this->categoria->setId($row['id']);
                $this->categoria->setNombre($row['nombre']);
                $this->categoria->setEstado($row['disabled']);
            }
        }
        return $this->categoria;
    }
}
