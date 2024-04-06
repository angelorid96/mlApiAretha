<?php

namespace mod_questions\entities;


class question
{

    private $poQuestion = null;

    public function __construct()
    {
        $this->poQuestion = new \mod_questions\plainObjects\questionPO();
    }
    public function getPO()
    {
        return $this->poQuestion;
    }

    public function insert()
    {
        $da = new \aretha\dao\DataAccess();
        $query = '';
        $query = sprintf(
            "INSERT INTO questions(id_question,seller_id,buyer_id,item_id,status,text,date_created,id_answer) VALUES (%d,%d,%d,'%s','%s','%s','%s',%d) RETURNING id;",
            $da->escape_string($this->poQuestion->getIdQuestion()),
            $da->escape_string($this->poQuestion->getSellerId()),
            $da->escape_string($this->poQuestion->getBuyerId()),
            $da->escape_string($this->poQuestion->getItemId()),
            $da->escape_string($this->poQuestion->getStatus()),
            $da->escape_string($this->poQuestion->getText()),
            $da->escape_string($this->poQuestion->getDateCreated()),
            $da->escape_string($this->poQuestion->getIDAnswer())
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
    public function insertWithoutIdAnswer()
    {
        $da = new \aretha\dao\DataAccess();
        $query = '';
        $query = sprintf(
            "INSERT INTO questions(id_question,seller_id,buyer_id,item_id,status,text,date_created) VALUES (%d,%d,%d,'%s','%s','%s','%s') RETURNING id;",
            $da->escape_string($this->poQuestion->getIdQuestion()),
            $da->escape_string($this->poQuestion->getSellerId()),
            $da->escape_string($this->poQuestion->getBuyerId()),
            $da->escape_string($this->poQuestion->getItemId()),
            $da->escape_string($this->poQuestion->getStatus()),
            $da->escape_string($this->poQuestion->getText()),
            $da->escape_string($this->poQuestion->getDateCreated())
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
            "SELECT id,id_question,seller_id,buyer_id,item_id,status,text,date_created,id_answer FROM questions WHERE id = %d;",
            $da->escape_string($this->poQuestion->getId())
        );

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                
                        foreach ($result as $row) {
                            $questionOP = new \mod_questions\plainObjects\questionPO();
                            $questionOP->setId($row[0]);
                            $questionOP->setIdQuestion($row[1]);
                            $questionOP->setSellerId($row[2]);
                            $questionOP->setBuyerId($row[3]);
                            $questionOP->setItemId($row[4]);
                            $questionOP->setStatus($row[5]);
                            $questionOP->setText($row[6]);
                            $questionOP->setDateCreated($row[7]);
                            $questionOP->setIDAnswer($row[8]);
                            $arrResult[] = $questionOP;
                        }
                    
            }
            return $arrResult;
        } else {
            return false;
        }
    }
    public function selectByIdQuestion()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "SELECT id,id_question,seller_id,buyer_id,item_id,status,text,date_created,id_answer FROM questions WHERE id_question = %d;",
            $da->escape_string($this->poQuestion->getIdQuestion())
        );

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                
                        foreach ($result as $row) {
                            $questionOP = new \mod_questions\plainObjects\questionPO();
                            $questionOP->setId($row[0]);
                            $questionOP->setIdQuestion($row[1]);
                            $questionOP->setSellerId($row[2]);
                            $questionOP->setBuyerId($row[3]);
                            $questionOP->setItemId($row[4]);
                            $questionOP->setStatus($row[5]);
                            $questionOP->setText($row[6]);
                            $questionOP->setDateCreated($row[7]);
                            $questionOP->setIDAnswer($row[8]);
                            $arrResult[] = $questionOP;
                        }
                    
            }
            return $arrResult;
        } else {
            return false;
        }
    }
    public function selectAll() {
		$da = new \aretha\dao\DataAccess();
		$query = "SELECT id,id_question,seller_id,buyer_id,item_id,status,text,date_created,id_answer FROM questions;";

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                foreach ($result as $row) { 
                    $questionOP = new \mod_questions\plainObjects\questionPO();
                    $questionOP->setId($row[0]);
                    $questionOP->setIdQuestion($row[1]);
                    $questionOP->setSellerId($row[2]);
                    $questionOP->setBuyerId($row[3]);
                    $questionOP->setItemId($row[4]);
                    $questionOP->setStatus($row[5]);
                    $questionOP->setText($row[6]);
                    $questionOP->setDateCreated($row[7]);
                    $questionOP->setIDAnswer($row[8]);
                    $arrResult[] = $questionOP;
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
        $query = sprintf(
            "SELECT COUNT(id) FROM questions WHERE id = %d;",
            $da->escape_string($this->poQuestion->getId())
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
    public function existIdQuestion()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "SELECT COUNT(id_question) FROM questions WHERE id_question = %d;",
            $da->escape_string($this->poQuestion->getIdQuestion())
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
        $query = sprintf("UPDATE questions SET id_question=%d,seller_id=%d,buyer_id=%d,item_id='%s',status='%s',text='%s',date_created='%s',id_answer=%d WHERE id=%d;",
            $da->escape_string($this->poQuestion->getIdQuestion()),
            $da->escape_string($this->poQuestion->getSellerId()),
            $da->escape_string($this->poQuestion->getBuyerId()),
            $da->escape_string($this->poQuestion->getItemId()),
            $da->escape_string($this->poQuestion->getStatus()),
            $da->escape_string($this->poQuestion->getText()),
            $da->escape_string($this->poQuestion->getDateCreated()),
            $da->escape_string($this->poQuestion->getIDAnswer()),
            $da->escape_string($this->poQuestion->getId())
        );
        if ($da->connect()) {
            $result = $da->execSetQuery($query);
            $da->disconnect();
            return $result;
        } else {
            return false;
        }
    }
    public function updateIdAnswer()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf("UPDATE questions SET id_answer=%d WHERE id=%d;",
            $da->escape_string($this->poQuestion->getIDAnswer()),
            $da->escape_string($this->poQuestion->getId())
        );
        if ($da->connect()) {
            $result = $da->execSetQuery($query);
            $da->disconnect();
            return $result;
        } else {
            return false;
        }
    }

    public function deleteById() {
		$da = new \aretha\dao\DataAccess();
		$query = sprintf("DELETE FROM questions WHERE id = %d;",
							$da->escape_string($this->poQuestion->getId())
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
    public function deleteByIdQuestion() {
		$da = new \aretha\dao\DataAccess();
		$query = sprintf("DELETE FROM questions WHERE id_question = %d;",
							$da->escape_string($this->poQuestion->getIdQuestion())
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
		$query = sprintf("SELECT id,id_question,seller_id,buyer_id,item_id,status,text,date_created,id_answer, ar.id, ar.text, ar.status, ar.date_created FROM questions JOIN answer as ar ON id_answer=ar.id %s;", //el comodin "%s" se mantiene por que va a cachar en el dts la busqueda dinamica
                        $this->poQuestion->getQuery_dinam());

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                foreach ($result as $row) { 
                    $questionOP = new \mod_questions\plainObjects\questionPO();
                    $answerOP = new \mod_questions\plainObjects\answerPO();
                    $questionOP->setId($row[0]);
                    $questionOP->setIdQuestion($row[1]);
                    $questionOP->setSellerId($row[2]);
                    $questionOP->setBuyerId($row[3]);
                    $questionOP->setItemId($row[4]);
                    $questionOP->setStatus($row[5]);
                    $questionOP->setText($row[6]);
                    $questionOP->setDateCreated($row[7]);
                    $questionOP->setIDAnswer($row[8]);
                    $answerOP->setId($row[9]);
                    $answerOP->setText($row[10]);
                    $answerOP->setStatus($row[11]);
                    $answerOP->setDateCreated($row[12]);
                    $arrResult[] =array('question'=>$questionOP,'answer'=>$answerOP);
                }
            }
            return $arrResult;
        } else {
            return false;
        }
            
    }

	public function countDinam(){ //cuenta la cantidad de datos encontrados en la tabla
        $da = new \aretha\dao\DataAccess();
        $query = sprintf("SELECT count(id) FROM questions JOIN answer as ar ON id_answer=ar.id %s;", //el comodin "%s" se mantiene por que va a cachar en el dts la busqueda dinamica
        $this->poQuestion->getQuery_dinam());
                    
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