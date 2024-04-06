<?php

namespace mod_questions\plainObjects;

class questionPO
{

    private $id;
    private $id_question;
    private $seller_id;
    private $buyer_id;
    private $item_id;
    private $status;
    private $text;
    private $date_created;
    private $id_answer;
    private $queryDinam = "";

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setIdQuestion($idQuestion)
    {
        $this->id_question = $idQuestion;
    }
    public function setSellerId($sellerId)
    {
        $this->seller_id = $sellerId;
    }
    public function setBuyerId($buyerId)
    {
        $this->buyer_id = $buyerId;
    }
    public function setItemId($itemID)
    {
        $this->item_id = $itemID;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
    }
    public function setIDAnswer($idAnswer)
    {
        $this->id_answer = $idAnswer;
    }
    public function setQuery_diam($queryDinam)
    {
        $this->queryDinam = $queryDinam;
    }

    
    public function getId()
    {
        return $this->id;
    }
    public function getIdQuestion()
    {
        return $this->id_question;
    }
    public function getSellerId()
    {
        return $this->seller_id;
    }
    public function getBuyerId()
    {
        return $this->buyer_id;
    }
    public function getItemId()
    {
        return $this->item_id;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getText()
    {
        return $this->text;
    }
    public function getDateCreated()
    {
        return $this->date_created;
    }
    public function getIDAnswer()
    {
        return $this->id_answer;
    }
    public function getQuery_dinam()
    {
        return $this->queryDinam;
    }
}
