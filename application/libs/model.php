<?php

abstract class Model{
    
    /**
     *
     * @var PDO
     */
    protected $db;
    
    public function loadDatabase($db){
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    public function beginTransaction(){
        $this->db->beginTransaction();
    }
    
    public function commit(){
        $this->db->commit();
    }
    
    public function rollBack(){
        $this->db->rollBack();
    }
    
}



