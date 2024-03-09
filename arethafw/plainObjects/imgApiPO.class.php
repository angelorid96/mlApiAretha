<?php
namespace mod_apitoken\plainObjects;

class imgApiPO{

    private $id;
    private $queryDinam = "";

    public function getId(){
        return $this->id;
    }

    public function getQuery_dinam(){
        return $this->queryDinam;
    }
    
    public function setId($id_){
        $this->id=$id_;
    }
    public function setQuery_diam($queryDinam){
        $this->queryDinam=$queryDinam;
    }
}

?>