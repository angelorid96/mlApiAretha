<?php

namespace mod_questions\plainObjects;

class answerPO
{

    private $id;
    private $status;
    private $text;
    private $date_created;
    private $queryDinam = "";

    public function setId($id)
    {
        $this->id = $id;
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
    public function setQuery_diam($queryDinam)
    {
        $this->queryDinam = $queryDinam;
    }


    public function getId()
    {
        return $this->id;
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
    public function getQuery_dinam()
    {
        return $this->queryDinam;
    }
}
