<?php

namespace mod_questions\entities;


class answer
{

    private $poAnswer = null;

    public function __construct()
    {
        $this->poAnswer = new \mod_questions\plainObjects\answerPO();
    }
    public function getPO()
    {
        return $this->poAnswer;
    }

    public function insert()
    {
        $da = new \aretha\dao\DataAccess();
        $query = '';
        $query = sprintf(
            "INSERT INTO answer(text,status,date_created) VALUES ('%s','%s','%s') RETURNING id;",
            $da->escape_string($this->poAnswer->getText()),
            $da->escape_string($this->poAnswer->getStatus()),
            $da->escape_string($this->poAnswer->getDateCreated())
        );


        // echo $query;
        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            // var_dump($result);
            $da->disconnect();
            if ($result != false) {
                return $result[0][0];  
            }
            return 0;
        } else {
            return 0;
        }
    }
    public function selectById()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "SELECT id,text,status,date_created FROM answer WHERE id = %d;",
            $da->escape_string($this->poAnswer->getId())
        );

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                
                        foreach ($result as $row) {
                            $answerPO = new \mod_questions\plainObjects\answerPO();
                            $answerPO->setId($row[0]);
                            $answerPO->setStatus($row[1]);
                            $answerPO->setText($row[2]);
                            $answerPO->setDateCreated($row[3]);
                            $arrResult[] = $answerPO;
                        }
                    
            }
            return $arrResult;
        } else {
            return false;
        }
    }    
    public function selectAll() {
		$da = new \aretha\dao\DataAccess();
		$query = "SELECT id,text,status,date_created FROM answer;";

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                foreach ($result as $row) { 
                    $answerPO = new \mod_questions\plainObjects\answerPO();
                    $answerPO->setId($row[0]);
                    $answerPO->setStatus($row[1]);
                    $answerPO->setText($row[2]);
                    $answerPO->setDateCreated($row[3]);                    
                    $arrResult[] = $answerPO;
                }
            }
            return $arrResult;
        } else {
            return false;
        }
    }
    public function existId()
    {
        $da = new \aretha\dao\DataAccess();
        var_dump($da);
        $query = sprintf(
            "SELECT COUNT(id) FROM answer WHERE id = %d;",
            $da->escape_string($this->poAnswer->getId())
        );
        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            if ($result != false) {
                        if ($result[0][0] > 0) {
                            return true;
                        }
            }
            return false;
        } else {
            return false;
        }
    }
    

    public function update()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf("UPDATE answer SET text='%s',status='%s',date_created='%s' where id=%d",
            $da->escape_string($this->poAnswer->getText()),    
            $da->escape_string($this->poAnswer->getStatus()),
            $da->escape_string($this->poAnswer->getDateCreated()),
            $da->escape_string($this->poAnswer->getId())
        );
        if ($da->connect()) {
            $result = $da->execSetQuery($query);
            $da->disconnect();
            return $result;
        } else {
            return false;
        }
    }
    public function delete() {
		$da = new \aretha\dao\DataAccess();
		$query = sprintf("DELETE FROM questions WHERE id = %d;",
							$da->escape_string($this->poAnswer->getId())
						);
		if ($da->connect()) {
			$result = $da->execSetQuery($query);
			$da->disconnect();
			if ($result != false) {
				return true;
			}
		}
		return false;		
	}

	public function selectDinam() {
		$da = new \aretha\dao\DataAccess();
		$query = sprintf("SELECT id,text,status,date_created FROM answer %s;", //el comodin "%s" se mantiene por que va a cachar en el dts la busqueda dinamica
                        $this->poAnswer->getQuery_dinam());

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                foreach ($result as $row) { 
                    $answerOP = new \mod_questions\plainObjects\answerPO();
                    $answerOP->setId($row[0]);
                    $answerOP->setText($row[1]);
                    $answerOP->setStatus($row[2]);
                    $answerOP->setDateCreated($row[3]);
                    $arrResult[] =$answerOP;
                }
            }
            return $arrResult;
        } else {
            return false;
        }
            
    }

	public function countDinam(){ //cuenta la cantidad de datos encontrados en la tabla
        $da = new \aretha\dao\DataAccess();
        $query = sprintf("SELECT count(id) FROM answer %s;", //el comodin "%s" se mantiene por que va a cachar en el dts la busqueda dinamica
        $this->poAnswer->getQuery_dinam());
                    
        if ($da->connect()){
            $result = $da->execGetQuery($query);
            // echo json_encode($result[0]);
            $da->disconnect();
            if ($result != false) {
                return $result[0][0];
            }
            return 0;
        } else {
            return 0;
        }                
    }

}


?>